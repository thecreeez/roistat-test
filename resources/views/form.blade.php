<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>

    <link href="{{ URL::asset('bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="w-100 m-auto" style="max-width: 400px;">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('status-error'))
            <div class="alert alert-danger" role="alert">
                {{ session('status-error') }}
            </div>
        @endif
        <h1 class="h3 mb-3 fw-normal">Форма отправки сделки</h1>
        <form action="{{ route('api.lead.put') }}" method="post">
            @method('PUT')
            @csrf

            <input type="hidden" id="isVisitLong" name="isVisitLong">

            <div class="form-floating pb-2">
                <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" id="nameInput" name="name" placeholder="Имя" value="{{ old('name') }}">
                <label for="nameInput">Имя</label>
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
            </div>
            <div class="form-floating pb-2">
                <input type="email" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" id="emailInput" name="email" placeholder="Email" value="{{ old('email') }}">
                <label for="emailInput">Почта</label>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>
            <div class="form-floating pb-2">
                <input type="text" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" id="phoneInput" 
                    name="phone" placeholder="Phone number" value="{{ old('phone') }}">
                <label for="phoneInput">Номер телефона</label>
                <div class="invalid-feedback">
                    {{ $errors->first('phone') }}
                </div>
            </div>
            <div class="form-floating pb-2">
                <input type="text" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" id="priceInput" name="price" placeholder="Price" value="{{ old('price') }}">
                <label for="priceInput">Сумма</label>
                <div class="invalid-feedback">
                    {{ $errors->first('price') }}
                </div>
            </div>

            <button class="btn btn-primary w-100 py-2 mt-3" type="submit" id="submitFormButton">Отправить</button>
        </form>
    </main>

    <script src="{{ URL::asset('bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('app.js') }}"></script>
</body>
</html>