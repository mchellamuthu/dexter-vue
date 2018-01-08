<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Dexter</title>
    <style media="screen">
      .code{
        background: #ccc;
        border: solid 1px #f1f1f1;
        padding: 20px 5px;
        width: 250px;
        margin-right: auto;
        margin-left: auto;
      }
      .page-break {
    page-break-after: always;
}
    </style>
  </head>
  <body style="text-align:center">
    @foreach ($codes as $data)
      <h4 >{{$data->student_first_name}} {{ $data->student_last_name }}'s Code for {{ $data->class_room }} </h4>
      <h4 class="code">{{ $data->code }}</h4>
      {{-- <br /> --}}
      {{-- <a href="http://dextervue.dev/src/{{$code}}">http://dextervue.dev/src/{{$code}}</a> --}}
      <div class="page-break"></div>
    @endforeach


  </body>
</html>
