<?php

namespace App\Services;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFields\CheckboxCustomFieldModel;
use AmoCRM\Models\CustomFieldsValues\CheckboxCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\CheckboxCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\CheckboxCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use Illuminate\Support\Facades\Log;
use Config;

class AmoCRMService {
    protected $client;

    public function __construct() {
        $this->client = new AmoCRMApiClient(config('api.clientId'), config('api.secretKey'));

        $this->client->setAccessToken(new LongLivedAccessToken(config('api.longLiveToken')))->setAccountBaseDomain(config('api.baseDomain') . '.amocrm.ru');
            
    }

    public function put(int $price, bool $isLongVisitor, string $name, string $email, string $phone): bool {
        $lead = $this->createLead($price, $isLongVisitor);
        $contact = $this->createContact($name, $email, $phone);

        try {
            $contact = $this->client->contacts()->addOne($contact);
            $lead = $this->client->leads()->addOne($lead);

            $links = new LinksCollection();
            $links->add($lead);

            $this->client->contacts()->link($contact, $links);
            return true;
        } catch (AmoCRMApiException $e) {
            Log::channel('amocrm_lead')->alert('Error with adding new lead: ' . $e->getMessage());
            return false;
        }
    }

    private function createLead(int $price, bool $isLongVisitor): LeadModel 
    {
        $lead = new LeadModel();
        $lead->setPrice($price);
        return $this->addLongVisitor($lead, $isLongVisitor);
    }
    
    private function addLongVisitor(LeadModel $lead, bool $isLongVisitor): LeadModel 
    {
        return $lead->setCustomFieldsValues(
            (new CustomFieldsValuesCollection())
                ->add(
                    (new CheckboxCustomFieldValuesModel())
                    ->setFieldId(419197)
                    ->setValues(
                        (new CheckboxCustomFieldValueCollection())
                        ->add(
                            (new CheckboxCustomFieldValueModel())
                                ->setValue($isLongVisitor)
                        )
                    )
                )
        );
    }

    private function createContact(string $name, string $email, string $phone): ContactModel 
    {
        $contact = new ContactModel();
        $contact->setName($name);
        $contact->setIsMain(true);
        return $this->addContactInfo($contact, $email, $phone);
    }

    private function addContactInfo(ContactModel $contact, string $email, string $phone) {
        return $contact->setCustomFieldsValues(
            (new CustomFieldsValuesCollection())
                ->add(
                    (new TextCustomFieldValuesModel())
                        ->setFieldCode('EMAIL')
                        ->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add(
                                    (new TextCustomFieldValueModel())
                                        ->setValue($email)
                                )
                        )
                )
                ->add(
                    (new TextCustomFieldValuesModel())
                        ->setFieldCode('PHONE')
                        ->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add(
                                    (new TextCustomFieldValueModel())
                                        ->setValue($phone)
                                )
                        )
                )
        );
    }
}