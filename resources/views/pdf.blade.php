<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>
<body>
    <h1>Items</h1>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Item Name</th>
                <th>Price</th>
            </tr>

            @if(isset($items) && count($items) > 0)
                @foreach ($items as $i => $item)
                    <tr>
                        <th>{{ $i+1 }}</th>
                        <th>{{ $item['item'] }}</th>
                        <th>{{ $item['price'] }}</th>
                    </tr>
                @endforeach
            @endif
        </thead>
    </table>
</body>
</html>