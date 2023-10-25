<?php

use App\Model\Product;
use Framework\Singleton\Router\Router;
?>

<!DOCTYPE html>
<html lang="en">
@include("partials.head", ["seoTitle"=>"{{seoTitle}}", "seoDescription"=>""])

<body>
    <div id="app">

        <div class="home-container">
            <h2>Listar Produtos</h2>
            <p>Lorem ipsum dolor sit amet</p>

            <div>
            <app-table
                        :head_labels="['Título', 'Preço']"
                        :rows="{{tableRows}}"
                    >

                    </app-table>
            </div>

        </div>
    </div>

    @include("partials.footer", [])
</body>

</html>