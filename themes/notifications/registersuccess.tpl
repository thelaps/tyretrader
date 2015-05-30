<html>
    <head>
        <title>Успешная регистрация на сервисе AutoManager</title>
    </head>
    <body>
        Приветствуем вас {$data->firstname} {$data->lastname}!<br><br>

        Вы только что успешно зарегистрировались на портале <a href="http://automanager.com.ua">AutoManager</a><br>

        Ваши регистрационные данные для входа в систему:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">Логин:</span> {$data->login}</h5><br>
            <h5><span style="font-weight: normal;">Пароль:</span> {$data->pass}</h5><br>
        </div>
    </body>
</html>