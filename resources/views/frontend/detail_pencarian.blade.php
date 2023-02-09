<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.min.css') }}">

<body>
    @if ($datasets->type == 'xls' or $datasets->type == 'xlsx')
        <div class="mx-auto text-center">
            <div class="mx-auto text-center">
                <embed type="text/html"
                    src="https://view.officeapps.live.com/op/embed.aspx?src={{ url('/file/'.$datasets->id .'/')}}"
                    width="1024" height="350">
            </div>
        </div> 
       
    @elseif ($datasets->type == 'csv' or $datasets->type == 'pdf')
        <div class="mx-auto text-center">
            <embed type="text/html"
                src="https://docs.google.com/gview?url={{ url('/file/'.$datasets->id .'/') }}&embedded=true"
                width="1024" height="350">
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <form action="/file/{{ $datasets->id }}">
            <button type="submit" class="btn btn-danger"><i class="fas fa-file-download"></i> Download File</button>
        </form>
    </div>
</body>

</html>
