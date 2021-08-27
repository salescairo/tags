<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>Courses Report</title>

    <style type="text/css">
        @font-face {
            font-family: 'poppins';
            src: url("../../../fonts/Poppins-Thin.ttf") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'poppins-bold';
            src: url("../../../fonts/Poppins-Bold.ttf") format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        .page-break {
            page-break-after: always;
        }
        .line-break {
            line-break: always;
        }

        body {
            font-family: 'poppins' !important;
        }

        b {
            font-family: 'poppins-bold' !important;
        }
    </style>
</head>

<body>
    <div>
        @php
        $count=0;
        @endphp

        @foreach($models as $model)
            <div style="padding:5mm;">

                <table align="middle" style="border-radius:6mm;margin-bottom: 20px;height:44mm;width: 79mm;border:1px solid #333;background: rgb(255,255,255);">
                    <tr>
                        <td colspan="2" style=" border-bottom:1px solid #333;text-align: center;font-size: 3mm;padding:1.5mm">
                            {{ env('SCHOOL_NAME', 'ESCOLINHA TAG KIDS')}}
                        </td>
                    </tr>
                    <tr style="padding: 0;">
                        <td style="width: 10mm;padding: 2mm">
                            <img style="border-radius: 3mm;vertical-align: middle;" src="{{ $model->photo() }}" height="90mm" width="60mm" />
                        </td>
                        <td style="text-align: left;vertical-align:top;font-size:2.5mm;padding-top:3mm;">
                            <b style="font-size: 3.0mm;">{{ $model->name }}</b><br>
                            <B>RM - {{ $model->identification }} </b><br>
                            <span style="padding-top:2mm;color:444">{{ $model->responsable1_name }} </span><br>
                            <span style="color:444">{{ $model->responsable1_phone }} </span><br><br>
                            <span style="color:444">{{ $model->responsable2_name }} </span><br>
                            <span style="color:444">{{ $model->responsable2_phone }} </span><br>
                        </td>
                    <tr>
                        <td colspan="2" style=" border-top:1px solid #333;text-align: center;font-size: 3mm;padding:1.5mm">
                            {{ $model->class->name }} - {{ $model->class->time }}
                        </td>
                    </tr>
                </table>
            </div>


                @if($count%2==0)
                    <div class="line-break"></div>
                @endif

            @php
            $count++;
            @endphp

        @endforeach
    </div>
</body>

</html>
