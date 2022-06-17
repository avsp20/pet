<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>PDF</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" width="16">
    <style type="text/css">
        table {
            border-collapse:separate;
        }
        a, a:link,
        a:visited {
            text-decoration: none;
            color: #00788a;
        }
        a:hover {
            text-decoration: underline;
        }
        h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {
            color:#000 !important;1
        }
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td {
            line-height: 100%;
        }
        .ExternalClass {
            width: 100%;
        }
    </style>

</head>

<body>
    <table style="background-image: url('{{ asset('public/images/eagle.png') }}');
    background-repeat: no-repeat;background-position: center;background-size: contain !important;margin: 0 auto;text-align: center;font-size: 22px;line-height: 24px;color: #000000; font-family:'Arial';">
        <tr>
            <td colspan="3">
                <img src="{{ asset('public/images/text.png') }}" style="60%">
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p style="margin: 0 0 15px 0;">
                 <span style="display: inline-block;vertical-align: middle;">
                     This is to certify that you
                 </span> 
                 <input type="text" class="textbox" value="{{ (!empty($data['pet_type'])) ? $data['pet_type'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;width: 35%;">
             </p>
             <p style="margin: 0 0 15px 0;"><textarea class="textbox" style="background: rgb(241 243 254 / 40%);border: 0;height: 50px;width: 80%;margin:auto !important;">{{ ($data['pet_name'] != null) ? $data['pet_name'] : "" }}</textarea></p>
             <p style="margin: 0 0 15px 0;">beloved companion and friend of the</p>
             <p style="margin: 0 0 15px 0;"><input type="text" class="textbox" value="{{ ($data['name'] != null) ? $data['name'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;width: 70%;"></p>
             <p style="margin: 0 0 14px 0;">family was cremated at Compassionate Pet Cremation, LLC on the</p>
             <p style="margin: 0 0 14px 0;"><input type="text" class="textbox" value="{{ ($data['date_cremated'] != null) ? $data['date_cremated'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;width: 70%;"></p>
             <p style="margin: 0 0 15px 0;">and these are the remains of the above named pet.</p>
             <p style="margin: 0 0 15px 0;">Age: <input type="text" class="textbox" value="{{ ($data['age'] != null) ? $data['age'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;"> Passes Away:<input type="text" class="textbox" value="{{ ($data['date_of_birth'] != null) ? $data['date_of_birth'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;"></p>
         </td>
     </tr>
     <tr>
        <td style="width:43%;">
            <p style="margin: 0 0 0px 0;font-weight: bold;font-size: 20px;">Compassionate Pet Cremation,<small>LLC</small></p>
            <p style="margin: 0 0 15px 0;border-bottom: 2px solid;max-width: 80%;margin: 0 auto 5px auto;;text-align: center;font-size: 18px;">You love them - We care</p>
            <p style="margin: 0;font-size: 11px;font-weight: 600;line-height: 12px;">401 Mark Leany Dr., Henderson, NY 89015, (702) 565-5617</p>
        </td>
        <td style="width:14%;">
            <img src="{{ asset('public/images/eagle-logo.png') }}" style="max-width: 70%;">
        </td>
        <td style="width:43%;vertical-align: bottom;">
            <p style="border-top: 2px solid;margin: 0 auto;font-weight: bold;font-style: italic;padding-top: 5px;">Allen Silberstain, President</p>
            <p style="margin: 0 0 15px 0;font-size: 16px;">Order No: <input type="text" class="textbox" value="{{ ($data['order_no'] != null) ? $data['order_no'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;width: 100px;"> Tag No:<input type="text" class="textbox" value="{{ ($data['tag'] != null) ? $data['tag'] : "" }}" style="background: rgb(241 243 254 / 40%);border: 0;height: 30px;width: 100px;"></p>
        </td>
    </tr>
</table>
</body>

</html>