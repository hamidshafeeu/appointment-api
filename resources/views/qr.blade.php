<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="flex flex-col h-screen items-center justify-center text-center visible-print">
        
        {!! QrCode::size(300)->generate(Request::url().now()); !!}
        <div class="pt-10">
            <p>{{ $booking->slot->center->name }}</p>
            <p>{{ $booking->slot->start }} TO {{ $booking->slot->end }}</p>
            <p>{{ $booking->slot->date }}</p>
        </div>
    </div>
</body>
</html>