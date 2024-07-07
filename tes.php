<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @page{
            size: 8cm 100cm;
        }

        @media print{
            .btn{
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="btn" onclick="window.print()">print</button>
    
</body>
</html>