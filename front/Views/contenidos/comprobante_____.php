<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante</title>
    <link rel="stylesheet" href="./front/Views/assets/css/bootstrap.min.css">
</head>

<body>

<?php 
    $productos = unserialize ($_COOKIE['productos'] ?? "");
    print_r($productos); 

?>


    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="table-responsive">
                <table
                class="table table-light">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            


                            <tr class="">
                                <td scope="row">R1C1</td>
                                <td>R1C2</td>
                                <td>R1C3</td>
                            </tr>
                            <tr class="">
                                <td scope="row">Item</td>
                                <td>Item</td>
                                <td>Item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</body>

</html>