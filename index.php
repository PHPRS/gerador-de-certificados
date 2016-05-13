<?php
require 'autoload.php';
require 'config-sample.php';

if (DEBUG) error_reporting(E_ALL);

# you can utilize a Json adapter
$adapter = new JsonAdapter(JSON_FILE);

# or a mysql adapter
# $adapter = new MysqlAdapter(DB_HOST, DB_NAME, DB_USER, DB_PASS);

# feel free for create more adapters!

if (!empty($_POST['email'])) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $results = $adapter->find($email);
    $images = array();

    foreach ($results as $attendee) {
        
        $first_name = explode(' ', $attendee['name'])[0];
        
        if (is_file(CACHE_PATH . '/' . $attendee['file'])) {
            $images[] = CACHE_DIR . '/' . $attendee['file'];
            continue;
        }

        $attendee['name'] = strtoupper(remove_accents($attendee['name']));
        $attendee['bg_file'] = 'img/bg-' . $attendee['type'] . '.png';
        $images[] = generate_image($attendee);

    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR" lang="pt-BR" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" href="styles.css" />
<meta name="robots" content="noindex,nofollow" />
<style type="text/css">
    .wrap { background-image:url('<?php echo TOP_LOGO; ?>'); }
</style>
</head>
<body>

    <div class="wrap">

        <?php if (!empty($first_name)) : ?>
            <h2>Oi, <?php echo $first_name; ?>!</h2>
        <?php endif; ?>

        <?php if (!empty($images) && is_array($images)) : ?>

            <p>
                Obrigado por participar do <?php echo EVENT_NAME ?>!
                <?php if (count($images) > 1) : ?>
                    Aqui estão seus certificados.
                <?php else : ?>
                    Aqui está seu certificado.
                <?php endif; ?>
            </p>

            <p>
                Qualquer problema, basta entrar em
                 <a href="<?php echo CONTACT_LINK ?>">contato</a>.
            </p>

            <div class="items">
                <?php foreach ($images as $img) : ?>
                    <div class="item">
                        <a href="<?php echo $img; ?>"><img src="<?php echo $img; ?>" width="250" /></a>
                    </div>
                <?php endforeach; ?>
            </div>

            <p>
                <small>Para salvar, clique com o botão direito e escolha
                "salvar como". Impressão em A4 90DPI.</small>
            </p>

        <?php else : ?>

            <?php if (isset($_POST['email'])) : ?>
                <p>
                    Não foi possível encontrar o seu e-mail. Caso você
                    continue tendo este problema, por favor entre em
                    <a href="http://2012.curitiba.wordcamp.org/">contato</a>
                    conosco informando o seu nome completo, e-mail, e as
                    atividades das quais você participou.
                </p>
            <?php endif; ?>

            <form name="emailinfo" action="" method="POST">
                <p>
                    Digite o e-mail que você cadastrou no formulário
                    de inscrição do evento:
                </p>
                <p><input type="text" name="email" value="" /></p>
                <p><input type="submit" value="Enviar" /></p>
            </form>

        <?php endif; ?>

    </div>

</body>
</html>
