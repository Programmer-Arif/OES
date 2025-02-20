<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <p>
        <b>Hii {{ $data['name'] }},</b> Your exam({{ $data['exam_name'] }}) have been reviewed.
        Now you can check your marks.
    </p>

    <a href="{{ $data['url'] }}">Click here to go to results page</a>
</body>
</html>