<?php 
include_once('dom/simple_html_dom.php');
$html = new simple_html_dom();
$value = $_POST['form'];
/* DATA */
$html->load($value);

/* FORM TAG */ 
$form = $html->find('form')[0];
$form_method = $form->attr['method'];
$form_url = $form->attr['url'];
$form_route = $form->attr['route'];
$form_action = $form->attr['action'];
$form_param = $form->attr['param'];
/* END FORM TAG */ 
/* LABEL TAGS */
$labels = $html->find('label');

$label=[];
$label_data=[];
for($i=0; $i < count($labels);$i++){
    if(count($labels->attr['data']) > 0){
        for($l=0; $l < count($labels->attr['data^']);$l++){
            $label_data[$l]=(object)[$labels->attr['data^'][$l]];   
        }
    }
    $label[$i] = (object)[
    'for' => $labels[$i]->attr['for'],
    'class' => $labels[$i]->attr['class'],
    'id' => $labels[$i]->attr['id'],
    'html'=>utf8_decode($labels[$i]->plaintext),
    'type'=>$labels[$i]->tag,
    'data' => $label_data,
    ];


}
$inputs = $html->find('input[type!=submit]');
$input=[];
$input_data=[];
for($i=0; $i < count($inputs);$i++){
    if(count($inputs->attr['data']) > 0){
        for($l=0; $l < count($inputs->attr['data^']);$l++){
            $input_data[$l]=(object)[$inputs->attr['data^'][$l]];   
        }
    }
    $input[$i] = (object)[
    'type' => $inputs[$i]->tag,
    'class' => $inputs[$i]->attr['class'],
    'id' => $inputs[$i]->attr['id'],
    'name' => $inputs[$i]->attr['name'],
    'placeholder' => $inputs[$i]->attr['placeholder'],
    'value' => $inputs[$i]->attr['value'],
    'data' => $input_data,
    ];


}
$label_input=[];
for($i=0;$i<count($labels);$i++){
   $label_input[$i]= (object)['label'=>$label[$i],'input'=>$input[$i]];
}
var_dump($label_input[0]);
/* LABEL TAGS */
if($form_url):?>

<textarea name="" id="" cols="100" rows="100">
    {{Form::open(array('url'=>'<?php echo $form_url;?>','method'=>'<?php echo $form_method; ?>' ))}}
    <?php foreach($label_input as $lb): ?>

        {{Form::<?php echo $lb->label->type;?>('<?php echo $lb->label->for;?>','<?php echo $lb->label->html;?>',array('class'=>'<?php echo $lb->label->class;?>','id'=>'<?php echo $lb->label->id;?>'))}}
        {{Form::<?php echo $lb->input->type;?>('<?php echo $lb->input->name;?>','<?php echo $lb->input->value;?>',array('class'=>'<?php echo $lb->input->class;?>','id'=>'<?php echo $lb->input->id;?>'))}}

    <?php endforeach; ?>
    {{Form::close()}}
</textarea> 

<?php elseif($form_route):?>

    <textarea name="" id="" cols="100" rows="50">
        {{Form::open(array('route'=> array(<?php echo $form_route?> ,$form_param)))}}
    </textarea> 

<?php elseif($form_action):?>

    <textarea name="" id="" cols="100" rows="50">
        {{Form::open(array('action'=><?php echo $form_ation?> ,'method'=> ,))}}
    </textarea> 

<?php endif; ?>


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="css/screen.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->

            <h1 class="section" role="heading" aria-level="1">Bienvenue sur le site de ....</h1>
            <section class="container">
                <h1 class="section" role="heading" aria-level="1">Contenu principal de la page</h1>

                <section class="banner">
                    <h1 class="section" role="heading" aria-level="1">Haut de contenu</h1>
                    <nav class="nav" id="nav" role="navigation">
                        <a href="#main" class="reader">Passer directement au contenu</a>
                        <h1 class="section" role="heading" aria-level="1">Navigation de la page</h1>
                    </nav>

                </section>
                <section class="main" id="main">
                   <h1 class="section" role="heading" aria-level="1">Contenu principal de la page</h1>
                   <form action="index.php" method="post">


                    <textarea name="form" id="form" style="min-height:300px; width:600px;margin:auto;display: block"> 
                        <form method="POST" url="index" param="cours-slug">
                            <label for="intitule" class="toto" id="totid" data-id="9990">Intitulé</label>
                            <input type="text" name="intitule" id="intitule" placeholder="Math" value="val">
                            <label for="distance" class="distance" id="distanceid" data-id="9990">Distance</label>
                            <input type="email" name="distance" id="distanceeee" placeholder="dzdz">
                        </form>
                    </textarea>
                    <button class="btn send">Envoyer</button>
                </form>
            </section>
            <footer class="foot" role="contentinfo">
               <h1 class="section" role="heading" aria-level="1">Informations additionelles à la page</h1>
               <a href="#main" class="reader">Remonter au contenu</a>
               <a href="#nav" class="reader">Revenir à la navigation</a>
           </footer>
       </section>

       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
       <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
       <script src="js/main.js"></script>

       <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
       <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
</body>
</html>
