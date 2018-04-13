<html>  
<head>  
    <title><?php echo $titolo; ?></title>  
</head>  
<body>  
  
<h1><?php echo $titolo; ?></h1>  
  
<?php foreach($commenti as $single) : ?>  
    <div class="comment">  
  
        <p>  
        Nome: <?php echo $single->name; ?> <br />  
        Email: <?php echo $single->email; ?> <br />  
        Website: <?php echo $single->website; ?> <br />  
        Data : <?php echo date('d m Y h:m', strtotime($single->time_insert)); ?> <br />  
        </p>  
          
        <p>  
        <?php echo $single->comment; ?>  
        </p>  
		<p>
		<a href="<? echo site_url('guestbook/deleteComment/'.$single->id); ?>">Cancella</a>  
        </p>
  
    </div>  
    <hr />  
<?php endforeach; ?>    
	<?php echo form_open('/guestbook/newcomment', array('method'=>'post')); ?>  
<p>  
    <?php echo form_label('Nome', 'nome'); ?><br />  
    <?php echo form_input(array('name'=>'nome') ); ?>  
</p>  
<p>  
    <?php echo form_label('Email', 'email'); ?><br />  
    <?php echo form_input(array('name'=>'email') ); ?>  
</p>  
<p>  
    <?php echo form_label('Website', 'website'); ?><br />  
    <?php echo form_input(array('name'=>'website') ); ?>  
</p>  
<p>  
    <?php echo form_label('Testo', 'commento'); ?><br />  
    <?php echo form_textarea(array('name'=>'commento', 'rows' => 10, 'cols' => 30) ); ?>  
</p>  
<p>  
    <?php echo form_submit(array('name'=>'newcomment', 'value'=>'Invia'));  ?>  
</p>  
<?php echo form_close(); ?>
</body>  
</html>  