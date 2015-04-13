<html>
    <head>
        <title>Попытка верификации оплаты</title>
    </head>
    <body>
        Пользователь: [#{$data.invoice->user->id}] {$data.invoice->user->firstname} {$data.invoice->user->lastname}<br><br>
        Платеж: [#{$data.invoice->id}] {$data.invoice->title} {$data.invoice->price}<br><br>

        Данные коллбека:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">SIGN:</span> {$data.post.data}</h5><br>
            <h5><span style="font-weight: normal;">DATA:</span> {$data.post.signature}</h5><br>
        </div>
    </body>
</html>