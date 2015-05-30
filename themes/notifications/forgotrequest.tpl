<html>
    <head>
        <title>Сброс пароля на сервисе AutoManager</title>
    </head>
    <body>
        Приветствуем вас {$data->user->firstname} {$data->user->lastname}!<br><br>

        Это письмо было отправлено вам для подтверждения сброса пароля<br>
        Если вы его не отправляли, просто проигнорируйте.<br>
        В случае если вы действительно забыли пароль, то нажмите на ссылку ниже и вам будет выслан ваш новый пароль.

        Ваша ссылка на сброс пароля:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <a href="{$data->link}">{$data->link}</a><br>
        </div>
    </body>
</html>