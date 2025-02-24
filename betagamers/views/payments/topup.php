<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="tips-noforg">
<h1><?=$data['h1']?></h1>
<form class='w3-form' action="<?=htmlspecialchars(URI); ?>" method='post'>
    <span class="error"><?=isset($data['form']['err']) ? implode('<br>', $data['form']['err']) : ''?></span><br><br>
    
    <input type='text' name='name' value="<?=$data['form']['name'] ??'' ?>" placeholder='<?=$data['input']['name']['placeholder']?>' required>
    
    <input type='email' name='email' value="<?=$data['form']['email'] ?? '' ?>" placeholder='<?=$data['input']['email']['placeholder']?>' required>
    
    <input type='number' name='amount' value="<?=$data['form']['amount'] ?? '' ?>" placeholder='<?=$data['input']['amount']['placeholder']?> (<?=$data['form']['currency']?>)' step=".01" required>
	
	<input type='submit' name='submit' value='Ok'>
	</select>
</form>
</div>
<?php include INCS.'/footer.php';?>