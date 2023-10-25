<?php
    use Framework\Singleton\Router\Router;
?>

<!DOCTYPE html>
<html lang="en">

@include("partials.head",['title'=>"{{title}}"])

<body>
    <h2>Contact</h2>
    
    <form method="post" action="<?php echo Router::get()->route("site.contact.send") ?>">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="<?php echo @$_POST['name'] ?>">
        </div>
        <div class="form-group">
            <label>Assunto</label>
            <input type="text" name="subject" value="<?php echo @$_POST['subject'] ?>">
        </div>
        <div class="form-group">
            <input type="submit" name="action" value="Salvar">
        </div>
    </form>
    @include("partials.footer",['copyright_year'=>"2022"])
</body>
</html>