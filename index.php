<?php 
include_once('dom/simple_html_dom.php');
$html = new simple_html_dom();
$value = $_POST['formToLaravel'];
/* DATA */
$html->load($value);
$totalForm = [];

/* FORM TAG */ 
$form = $html->find('form')[0];
$form_method = $form->attr['method'];
$form_url = $form->attr['url'];
$form_route = $form->attr['route'];
$form_action = $form->attr['action'];
$form_param = $form->attr['param'];
foreach($html->find('form') as $form){

    foreach($form->children as $item){
        var_dump($item->tag);
    }
}
/* END FORM TAG */ 
/* LABEL & INPUT TAGS */
/* LABEL */
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
    'html'=>$labels[$i]->plaintext,
    'type'=>$labels[$i]->tag,
    'data' => $label_data,
    ];


}
/* INPUT */
$inputs = $html->find('input[type=text],input[type=email],input[type=button],input[type=checkbox],input[type=color],input[type=date],,input[type=datetime],input[type=datetime-local],,input[type=file],input[type=image],input[type=month],input[type=number],input[type=password],input[type=radio],input[type=range],input[type=reset],input[type=search],input[type=tel],input[type=time],input[type=url],input[type=week]');

$input=[];
$input_data=[];
for($i=0; $i < count($inputs);$i++){
    if(count($inputs->attr['data']) > 0){
        for($l=0; $l < count($inputs->attr['data^']);$l++){
            $input_data[$l]=(object)[$inputs->attr['data^'][$l]];   
        }
    }
    $input[$i] = (object)[
    'type' => $inputs[$i]->attr['type'],
    'class' => $inputs[$i]->attr['class'],
    'id' => $inputs[$i]->attr['id'],
    'name' => $inputs[$i]->attr['name'],
    'placeholder' => $inputs[$i]->attr['placeholder'],
    'value' => $inputs[$i]->attr['value'],
    'data' => $input_data,
    ];


}

/* TEXTAREA */
$textareas = $html->find('p');
$textarea=[];
//$input_data=[];
for($i=0; $i < count($textareas);$i++){
    $textarea[$i] = (object)[
    'type' => $textareas[$i]->attr['type'],
    'class' => $textareas[$i]->attr['class'],
    'id' => $textareas[$i]->attr['id'],
    'name' => $textareas[$i]->attr['name'],
    'cols' => $textareas[$i]->attr['cols'],
    'rows' => $textareas[$i]->attr['rows'],
    'placeholder' => $textareas[$i]->attr['placeholder'],
    'html' => $textareas[$i]->attr['html'],
    ];
}

/* END TEXTAREA */
$label_input=[];
if(count($labels) > count($input)){
    for($i=0;$i<count($labels);$i++){
       $label_input[$i]= (object)['label'=>$label[$i],'input'=>$input[$i],'textarea'=>$textarea[$i]];
   }
}else{
    for($i=0;$i<count($inputs);$i++){
       $label_input[$i]= (object)['label'=>$label[$i],'input'=>$input[$i],'textarea'=>$textarea[$i]];
   }
}
/* END LABEL & INPUT TAGS */

/* INPUT HIDDEN */

$hiddens = $html->find('input[type=hidden]');
$hidden = [];
for($i=0; $i < count($hiddens);$i++){

    $hidden[$i] =(object)[
    'type' => $hiddens[$i]->attr['type'],
    'class' => $hiddens[$i]->attr['class'],
    'name' => $hiddens[$i]->attr['name'],
    'id' => $hiddens[$i]->attr['id'],
    'value'=> $hiddens[$i]->attr['value'],
    ];
}

/* END INPUT HIDDEN */
/* INPUT SUBMIT */
$submits = $html->find('input[type=submit]')[0];
$submit = [];
$submit =(object)[
'type' => $submits->attr['type'],
'class' => $submits->attr['class'],
'id' => $submits->attr['id'],
'value'=> $submits->attr['value'],
];

/* END INPUT SUBMIT*/

/* END INPUT SUBMIT*/
/*$i=0;
foreach($html->find('form',0) as $form){
    $totalForm[$i] = (object)[
    'label'=>$label,
 'input'=>$input,
    'textarea'=>$textarea,
    'hidden'=>$hidden,
    'submit'=>$submit,
    ]
    $i++;
}*/

if($form_url):?>

<textarea name="" id="" cols="100" rows="100">
    {{Form::open(array('url'=>'<?php echo $form_url;?>','method'=>'<?php echo $form_method; ?>' ))}}
    <?php foreach($label_input as $lb): ?>
        <?php if($lb->label): ?>
            {{Form::<?php echo $lb->label->type;?>('<?php echo $lb->label->for;?>','<?php echo $lb->label->html;?>',array('class'=>'<?php echo $lb->label->class;?>','id'=>'<?php echo $lb->label->id;?>'))}}
        <?php endif; ?>
        <?php if($lb->input): ?>
            {{Form::<?php echo $lb->input->type;?>('<?php echo $lb->input->name;?>','<?php echo $lb->input->value;?>',array('class'=>'<?php echo $lb->input->class;?>','id'=>'<?php echo $lb->input->id;?>'))}}
        <?php endif; ?>
        <?php if($lb->textarea): ?>    
            {{Form::<?php echo $lb->textarea->type;?>('<?php echo $lb->textarea->name;?>','<?php echo $lb->textarea->html;?>',array('class'=>'<?php echo $lb->textarea->class;?>','id'=>'<?php echo $lb->textarea->id;?>'))}}
        <?php endif; ?>

    <?php endforeach; ?>
    <?php if($hidden): ?>
        <?php foreach($hidden as $hd): ?>
            {{Form:<?php echo $hd->type;?>('<?php echo $hd->name;?>','<?php echo $hd->value;?>',array('class'=>'<?php echo $hd->class;?>','id'=>'<?php echo $hd->id;?>'))}}
        <?php endforeach; ?>
    <?php endif; ?>
    {{Form::<?php echo $submit->type;?>('<?php echo $submit->value;?>',array('class'=>'<?php echo $submit->class;?>','id'=>'<?php echo $submit->id;?>'))}}
    {{Form::close()}}
}
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


                    <textarea name="formToLaravel" id="formToLaravel" style="min-height:300px; width:600px;margin:auto;display: block"> 
                        <form method="POST" url="index" param="cours-slug">
                            <label for="intitule" class="toto" id="totid" data-id="9990">Intitulé</label>
                            <input type="text" name="intitule" id="intitule" placeholder="Math" value="val">
                            <label for="distance" class="distance" id="distanceid" data-id="9990">Distance</label>
                            <input type="email" name="distance" id="distanceeee" placeholder="dzdz">
                            <select name="select" id="selectid">
                                <option selected value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <p name="toto" type="textarea" id="totoid" class="boudin" cols="30" rows="10">beurk</p>
                            <input type="hidden" name="data" class="data for the win" value="data:{test:{top:2,lol:4}}">
                            <input type="submit" class="btn secondary" value="Envoyer">
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
