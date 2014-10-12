<html>
    <head>
        <title>Успешная регистрация на сервисе</title>
    </head>
    <body>
        Приветствуем вас {$data->user->firstname} {$data->user->lastname}!<br><br>

        Это письмо было отправлено вам после подтверждения сброса пароля<br>

        Ваши новые данные для входа в систему:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">Логин:</span> {$data->user->login}</h5><br>
            <h5><span style="font-weight: normal;">Пароль:</span> {$data->newpass}</h5><br>
        </div>
    </body>
</html>