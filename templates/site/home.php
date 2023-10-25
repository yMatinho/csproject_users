<?php

use Framework\Singleton\Router\Router;
?>

<!DOCTYPE html>
<html lang="en">
@include("partials.head", ["seoTitle"=>"{{seoTitle}}", "seoDescription"=>""])

<body>
    <div class="home-container">
        <h2>Home</h2>
        <p>Aplicação CRUD de teste para a QAT</p>
        <div class="btns">
            <a href="<?php echo Router::get()->route("product.create") ?>"><button>Criar Produto</button></a>
            <a href="<?php echo Router::get()->route("product.list") ?>"><button>Listar Produtos</button></a>
        </div>
    </div>

    @include("partials.footer", [])
</body>

</html>