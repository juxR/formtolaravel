<?php 
include_once('dom/simple_html_dom.php');
$html = new simple_html_dom();
$value = $_POST['formToLaravel'];
/* DATA */
$html->load($value);
$totalForm = [];
$tags = [];
function whichTag( $tagName, $data ){
    //var_dump($data);

    if($tagName === "label"){
        if($data->tag){
            if($data->for){
                $for = $data->for; 
            }
            else{
                $for = "";
            }
            if($data->style){
                $style = ',"style"=>'.$data->style; 
            }
            else{
                $style = "";
            }
            if($data->class){
                $class = ',"class"=>'.$data->class; 
            }
            else{
                $class = "";
            }
            if($data->id){
                $id = ',"id"=>'.$data->id; 
            }
            else{
                $id = "";
            }
            if($data->placeholder){
                $placeholder = ',"placeholder"=>'.$data->placeholder; 
            }
            else{
                $placeholder = "";
            }
            return '{{Form::'. $data->tag.'("'. $for.'","'.utf8_decode($data->html).'" ,array('.$class.''.$id.''.$style.''.$placeholder.'))}}';
        }else{
            return 'error, no tag found';
        }
    }
    elseif($tagName === "input"){

        if($data->tag){
           if($data->type){
            $type = $data->type; 
        }
        else{
            $type = "";
        }
        if($data->style){
            $style = ',"style"=>'.$data->style; 
        }
        else{
            $style = "";
        }
        if($data->class){
            $class = ',"class"=>'.$data->class; 
        }
        else{
            $class = "";
        }
        if($data->id){
            $id = ',"id"=>'.$data->id; 
        }
        else{
            $id = "";
        }
        if($data->placeholder){
            $placeholder = ',"placeholder"=>'.$data->placeholder; 
        }
        else{
            $placeholder = "";
        }
        return '{{Form::'. $data->tag.'("'. $type.'","'.utf8_decode($data->value).'" ,array('.$class.''.$id.''.$style.''.$placeholder.'))}}';
    }else{
        return 'error, no tag found';
    }
}
elseif($tagName === "textarea"){

}
elseif($tagName === "select"){ //  name,array,default,
var_dump($data->selected);

   /* if($data->tag){
       if($data->tag){
        $tag = $data->tag; 
    }
    else{
        $tag = "";
    }
    if($data->style){
        $style = ',"style"=>'.$data->style; 
    }
    else{
        $style = "";
    }
    if($data->class){
        $class = ',"class"=>'.$data->class; 
    }
    else{
        $class = "";
    }
    if($data->id){
        $id = ',"id"=>'.$data->id; 
    }
    else{
        $id = "";
    }
    if($data->options){
        $options = $data->options; 
    }
    else{
        $options = "";
    }

    */

   // return '{{Form::'. $data->tag.'("'. $name.'","'.$data->options.'" ,array('.$class.''.$id.''.$style.''.$placeholder.'))}}';
}
}
/* FORM TAG */ 
/*$form = $html->find('form')[0];
$form_method = $form->attr['method'];
$form_url = $form->attr['url'];
$form_route = $form->attr['route'];
$form_action = $form->attr['action'];
$form_param = $form->attr['param'];*/
$form = $html->find('form');
for($i=0;$i < count($form); $i++){
    $form_tag[$i] = (object)[
    'method'=>$form[$i]->attr['method'],
    'url'=>$form[$i]->attr['url'],
    'route'=>$form[$i]->attr['route'],
    'files'=>$form[$i]->attr['enctype'],
    'action'=>$form[$i]->attr['action'],
    'param'=>$form[$i]->attr['param'],
    'class'=>$form[$i]->attr['class'],
    'id'=>$form[$i]->attr['id'],
    'style'=>$form[$i]->attr['style'],
    ];

    for($u=0;$u < count($form[$i]->children); $u++){
        $that = $form[$i]->children[$u];
        for($d=0; $d < count($that->find('option')); $d++){
            $option = $that->find('option')[$d];
            $selected = [];
            $options[$d] = [
            'html' => $option->plaintext,
            ];

            if($option->attr['selected']){
                array_push($selected,$option->attr['selected']);
            }





        }
        $tags[$u]=(object)[
        'tag'=>$that->tag,
        'type'=>$that->attr['type'],
        'for' => $that->attr['for'],
        'class' => $that->attr['class'],
        'id' => $that->attr['id'],
        'style'=>$that->attr['style'],
        'html'=>$that->plaintext,
        'name' => $that->attr['name'],
        'placeholder' => $that->attr['placeholder'],
        'value' => $that->attr['value'],
        'cols' => $that->attr['cols'],
        'rows' => $that->attr['rows'],
        'selected' => $selected,
        'options' => $options, //ATTR tag, selected, value 
        ];

    }
    $totalForm = (object)[

    'form'=>$form_tag,
    'tags'=>$tags,
    ];
}

/* END FORM TAG */ 
/* LABEL & INPUT TAGS */
/* LABEL */
/*$labels = $html->find('label');

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


}*/
/* INPUT */
/*$inputs = $html->find('input[type=text],input[type=email],input[type=button],input[type=checkbox],input[type=color],input[type=date],,input[type=datetime],input[type=datetime-local],,input[type=file],input[type=image],input[type=month],input[type=number],input[type=password],input[type=radio],input[type=range],input[type=reset],input[type=search],input[type=tel],input[type=time],input[type=url],input[type=week]');

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


}*/

/* TEXTAREA */
/*$textareas = $html->find('p');
$textarea=[];*/
//$input_data=[];
/*for($i=0; $i < count($textareas);$i++){
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
}*/

/* END TEXTAREA */
/*$label_input=[];
if(count($labels) > count($input)){
    for($i=0;$i<count($labels);$i++){
     $label_input[$i]= (object)['label'=>$label[$i],'input'=>$input[$i],'textarea'=>$textarea[$i]];
 }
}else{
    for($i=0;$i<count($inputs);$i++){
     $label_input[$i]= (object)['label'=>$label[$i],'input'=>$input[$i],'textarea'=>$textarea[$i]];
 }
}*/
/* END LABEL & INPUT TAGS */

/* INPUT HIDDEN */

/*$hiddens = $html->find('input[type=hidden]');
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
*/
/* END INPUT HIDDEN */
/* INPUT SUBMIT */
/*$submits = $html->find('input[type=submit]')[0];
$submit = [];
$submit =(object)[
'type' => $submits->attr['type'],
'class' => $submits->attr['class'],
'id' => $submits->attr['id'],
'value'=> $submits->attr['value'],
];*/

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

$forms = $totalForm->form;
$tags = $totalForm->tags;

foreach($totalForm->form as $form):

    if($form->url):?>

<textarea name="" id="" cols="100" rows="100">
    {{Form::open(array('url'=><?php if($form->param):?>'array('<?php echo $form->url; ?>','<?php echo $form->param;?>')'<?php else:?> '$form->url' <?php endif;?>,'method'=>'<?php echo $form->method; ?>'<?php $form->files ? ',files => true' : '';?><?php if($form->class):?>,'class'=>'<?php echo $form->class;?>'<?php else:?>''<?php endif;?> <?php if($form->id):?>,'id'=>'<?php echo $form->id;?>'<?php else:?>''<?php endif;?> <?php if($form->style):?>,'style'=>'<?php echo $form->style;?>'<?php else:?>''<?php endif;?>))}}
    <?php foreach($tags as $tag): ?>

        <?php echo whichTag($tag->tag, $tag); ?>
    <?php  endforeach; ?>

    {{Form::close()}}

</textarea> 

<?php elseif($form->route):?>

    <textarea name="" id="" cols="100" rows="50">
        {{Form::open(array('route'=> array(<?php echo $form_route?> ,$form_param)))}}
    </textarea> 

<?php elseif($form->action):?>

    <textarea name="" id="" cols="100" rows="50">
        {{Form::open(array('action'=><?php echo $form_ation?> ,'method'=> ,))}}
    </textarea> 

<?php endif; ?>

<?php endforeach; ?>

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
                <form method="POST" url="index" param="cours-slug" class="toptopd" id="tdid" style="border:1px solid black;">
                    <label for="intitule" class="toto" id="totid" data-id="9990">Intitulé</label>
                    <input type="text" name="intitule" id="intitule" placeholder="Math" value="val">
                    <label for="distance" class="distance" id="distanceid" data-id="9990">Distance</label>
                    <input type="email" name="distance" id="distanceeee" placeholder="dzdz">
                    <select name="select" id="selectid">
                        <option selected value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>

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
