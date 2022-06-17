<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <!-- <link href="https://db.onlinewebfonts.com/c/2be69b086861672e6a0ed050ffdd4fe7?family=ITC+Edwardian+Script" rel="stylesheet" type="text/css"/> -->
    <title>Document</title>
</head>
<style type="text/css">
   /* @import url(https://db.onlinewebfonts.com/c/2be69b086861672e6a0ed050ffdd4fe7?family=ITC+Edwardian+Script);*/
   body {
    font-family: "Roboto";
    height: 100% !important;
    width: 100% !important;
    -ms-text-size-adjust: 100%;
    margin: 0;
    padding: 0;
}

table {
    border-collapse: collapse;
    border: none;
}

table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

img {
    -ms-interpolation-mode: bicubic;
}

a {
    text-decoration: none;
}

a,
a:link,
a:visited {
    text-decoration: none;
    color: #00788a;
}

a:hover {
    text-decoration: none;
}

h2,
h2 a,
h2 a:visited,
h3,
h3 a,
h3 a:visited,
h4,
h5,
h6,
.t_cht {
    color: #000 !important;
}

.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td {
    line-height: 100%;
}
</style>

<body>
    <table class="table-pdf" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-image: url(https://cpc.blackrockcode.com/public/images/eagle.png) !important;background-repeat:no-repeat !important;background-size: contain !important;margin: auto;    background-position: center -30px !important;font-size: 20px;margin-top: 20px;font-family: sans-serif;">
        <tbody>
            <tr>
                <td style="padding: 40px 0;text-align: center;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    <img src="{{ asset('public/images/certificate-text.png') }}" style="width: 80%;">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">
                                    <span style="display: inline-block;vertical-align:middle;">This is to certify that your</span>
                                    <span style="display: inline-block;vertical-align:middle;line-height: 30px;text-align: center;margin-left: 5px;height: 30px;box-sizing: border-box;line-height: 30px;">{{ (!empty($data['pet_type'])) ? $data['pet_type'] : "" }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;padding-bottom: 10px;">
                                    <span style="display: block;text-align: center;margin: auto;box-sizing: border-box;font-family: cursive;font-style: italic;
                                    font-size: 50px;
                                    ">{{ ($data['pet_name'] != null) ? $data['pet_name'] : "" }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;padding-bottom: 10px;">
                                    <p style="margin:0;margin-bottom: 10px;">
                                        beloved companion and friend of the
                                    </p>
                                    <span style="display: block;text-align: center;margin: auto;height: 30px;line-height: 30px;
                                    box-sizing: border-box;font-size: 20px;font-weight: bold;">{{ ($data['name'] != null) ? $data['name'] : "" }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;padding-bottom: 10px;">
                                    <p style="margin:0;margin-bottom: 10px;">
                                        family was cremated at Compassionate Pet Cremation, LLC on the
                                    </p>
                                    <span style="display: block;line-height: 30px;text-align: center;margin: auto;height: 30px;
                                    box-sizing: border-box;">{{ ($data['date_cremated'] != null) ? $data['date_cremated'] : "" }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;padding-bottom: 10px;">
                                    <p style="margin:0;margin-bottom: 10px;">
                                        and these are the remains of the above named pet.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" width="50%">
                                        <tbody>
                                            <tr>
                                                <td width="50%" align="right" style="padding-right: 20px;">
                                                    <span style="display: inline-block;vertical-align:middle;">Age:</span>
                                                    <span style="display: inline-block;vertical-align:middle;
                                                    line-height: 30px;text-align: center;margin-left: 5px;height: 30px;
                                                    box-sizing: border-box;width: 100px;
                                                    text-align: center;
                                                    border-bottom: 2px solid;">{{ ($data['age'] != null) ? $data['age'] : "" }}</span>
                                                </td>
                                                <td width="50%" align="left">
                                                    <span style="display: inline-block;vertical-align:middle;">Passed Away:</span>
                                                    <span style="display: inline-block;vertical-align:middle;line-height: 30px; text-align: center;margin-left: 5px;height: 30px;    width: 100px;
                                                    text-align: center;
                                                    border-bottom: 2px solid;
                                                    box-sizing: border-box;">{{ ($data['date_of_birth'] != null) ? $data['date_of_birth'] : "" }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <table width="80%" cellpadding="0" cellspacing="0" border="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td width="43%" align="left" valign="center" style="text-align: center;">
                                                    <p style="margin: 0 0 0px 0;font-weight: bold;font-size: 20px;">Compassionate Pet Cremation,<small>LLC</small></p>
                                                    <p style="margin: 0 0 15px 0;border-bottom: 2px solid;max-width: 70%;margin: 0 auto 5px auto;;text-align: center;font-size: 18px;">You love them - We care</p>
                                                    <p style="margin: 0;font-size: 11px;font-weight: 600;line-height: 12px;">401 Mark Leany Dr., Henderson, NY 89015, (702) 565-5617</p>
                                                </td>
                                                <td width="14%" align="center" valign="center">
                                                    <img src="https://cpc.blackrockcode.com/public/images/eagle-logo.png" alt="" width="100" style="max-width: 100% !important;">
                                                </td>
                                                <td width="43%" align="left" valign="center" style="text-align: left;">
                                                    <span style="max-width:70%;
                                                    width: 100%;
                                                    display: inline-block;line-height: 30px; background-color: transparent;text-align: center;margin-left: 5px;height: 30px;
                                                    box-sizing: border-box;border-bottom: 2px solid #000;margin-bottom: 0px;"></span>
                                                    <span style="max-width:70%;
                                                    width: 100%;
                                                    display: inline-block;
                                                    line-height: normal;
                                                    background-color: transparent;
                                                    text-align: center;
                                                    box-sizing: border-box;
                                                    margin-bottom: 0;
                                                    ">Allen Silberstein, President</span>

                                                    <table cellpadding="0" cellspacing="0" border="0" align="left" width="80%" style="font-size: 18px;">
                                                        <tbody>
                                                            <tr>
                                                                <td width="50%" align="left" style="padding-right: 10px;">
                                                                    <span style="display: inline-block;vertical-align:middle;">Order No:</span>
                                                                    <span style="display: inline-block;vertical-align:middle;line-height: 30px; text-align: center;margin-left: 5px;height: 30px;
                                                                    box-sizing: border-box;">{{ ($data['order_no'] != null) ? $data['order_no'] : "" }}</span>
                                                                </td>
                                                                <td width="50%" align="left">
                                                                    <span style="display: inline-block;vertical-align:middle;">Tag No:</span>
                                                                    <span style="display: inline-block;vertical-align:middle;line-height: 30px; text-align: center;margin-left: 5px;height: 30px;
                                                                    box-sizing: border-box;">{{ ($data['tag'] != null) ? $data['tag'] : "" }}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>