<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <p>Olá, {{ $user->first_name }},</p>
    <p>Seja bem-vindo(a) ao sistema de gestão {{ config('app.name') }}. Por favor, verifique seu e-mail clicando no link
        abaixo.</p>


    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
            <tr>
                <td align="center">
                    <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{ $verifyEmailLink }}" target="_blank">VERFICIAR E-MAIL</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <p>Ou, simplesmente copie e cole o link abaixo em seu navegador:</p>
    <p>{{ $verifyEmailLink }}</p>

</body>

</html>
