<?php 


require 'config.php';



// Список офферов
$result = pg_query($dbconn, "SELECT * FROM offers ORDER BY offer_id DESC");

$offers = pg_fetch_all($result);

// Тип оффера
$result = pg_query($dbconn, "SELECT * FROM offers_data");

$types = json_encode(pg_fetch_all($result));

$types_arr = pg_fetch_all($result);


// Каналы
$result = pg_query($dbconn, "SELECT * FROM channels");

$channels = pg_fetch_all($result);



// Тэги
$result = pg_query($dbconn, "SELECT * FROM tags");

$tags = pg_fetch_all($result);


// Последний оффер
$result = pg_query('SELECT MAX(offer_id) from offers');
$maxArr = pg_fetch_row($result);

?>



<!DOCTYPE html>
<html>
<head>
	<title>Table</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<div class="wrap">
 		<div class="sidebar">
 			<h2>Офферы</h2>
 			<!-- <p>Тэги</p> -->
 		</div>
 		<div class="table">
			<table>
			  <thead>
			  	 <tr class="search">
			      	<th><div class="search-input" data-id='1'><input type="" name="" > <img width="15" src="images/search.svg"></div></th>
			      	<th><div class="search-input" data-id='2'><input type="" name=""> <img width="15"  src="images/search.svg"></div></th>
			      	<th><div class="search-input" data-id='3'><input type="" name="" > <img width="15"   src="images/search.svg"></div></th>
			      	<th><div class="search-input" data-id='4'><input type="" name=""> <img width="15"  src="images/search.svg"></div></th>
			      	<th><div class="search-input" data-id='5'><input type="" name=""> <img width="15"  src="images/search.svg"></div></th>
			      	<th></th>
			      	<!-- <th></th> -->
			      	<th style="width: 200px;"><button type="button" class="add" data-toggle="modal" data-target="#exampleModalLong"><span>+</span>Новый оффер</button></th>

			    </tr>
			    <tr>
			      	<th>ID</th>
					<th>Описание</th>
					<th>Активен</th>
					<th>Каналы</th>
					<th>Тэги</th>
					<th></th>
					<th></th>
					<!-- <th></th> -->
			    </tr>
			  </thead>
			  <tbody>
			  <?php 
					foreach ($offers as $key => $value) {
						?>
							
							<tr class="offer_row" data-id='<?= $value['offer_id']?>'>
								<td  data-id='1'><?= $value['offer_id']?></td>
								<td  data-id='2'><?= $value['description']?></td>
								<td  data-id='3'><?php 

								if ($value['is_active'] == 't') {
								 	echo "Активен";
								 } else {
								 	echo "Не активен";
								 }  ?></td>
								<td  data-id='4'>
									<?php foreach ($channels as $channel): ?>
										<?php 
											if (is_array($types_arr)) {
												foreach ($types_arr as $type) {
													if ($value['offer_id'] == $type['offer_id']) {
														if ($type['channel_id'] == $channel['channel_id']) {
															echo $channel['descr'];
															echo "<br>";
														}
													}
												}
											}
										?>
									<?php endforeach ?>
								</td>
								<td  data-id='5'>

									<?php

									$offer_tags = json_decode($value['taggs']);
									if (is_array($offer_tags)) {
										foreach ($offer_tags as $offer_tag) {
											foreach ($tags as $tag) {
												if ($offer_tag == $tag['tagid']) {
													echo $tag['tagname'];
													echo "<br>";
												}
											}
										}

									}
						
									?>

									</td>
								<td style="color: black; "><button class="edit_offer_button" type="button" data-toggle="modal" data-target="#EditModal"><a><img width="20" src="/images/pencil.svg"></a></button></td>
								<td ><a style="color: red; font-size: 25px;" href="/actions/delete.php?id=<?= $value['offer_id']?>">&times;</a></td>
								<!-- <td></td> -->
								<input type="hidden" class="offer_id_hide" value="<?= $value['offer_id']?>">
								<input type="hidden" class="description_hide" value="<?= $value['description']?>">
								<input type="hidden" class="active_hide" value="<?= $value['is_active']?>">
								<input type="hidden" class="taggs_hide" value='<?= $value['taggs']?>'>
							</tr>
						<?php 
					}

				?>
			  </tbody>
			</div>
		</table>

		<form class="footer" action="/actions/message.php" method="POST">
			<h2>Детали оффера:  <span style="font-weight: bold" class="description-edit-span"></span></h2>
			<div class="footer-edit">
				<div class="edit-type">
					<?php $count = 0; ?>

					<?php foreach ($channels as $key => $value): ?>
						<?php $count++; ?>
						<?php if ($count == 1): ?>
							<p  data-id="<?=$value['channel_id']?>">
							<input checked="" class="edit-type-input-<?=$value['channel_id']?>" type="checkbox">
								<?=$value['descr']?>
							</p>
						<?php else: ?>
							<p  data-id="<?=$value['channel_id']?>">
							<input class="edit-type-input-<?=$value['channel_id']?>" type="checkbox">
								<?=$value['descr']?>
							</p>
						<?php endif ?>
					<?php endforeach ?>
				</div>
				<div class="edit-message">
					<input type="hidden" name="offer_id" class="offer_id-input">
					<p>Сообщение</p>
					<?php $count = 0; ?>
					<?php foreach ($channels as $key => $value): ?>
						<?php $count++; ?>

						<?php if ($count == 1): ?>
							<textarea style="display: block;" name="message-<?=$value['channel_id']?>" class="message message-<?=$value['channel_id']?>"></textarea>
						<?php else: ?>
							<textarea class="message message-<?=$value['channel_id']?>"  name="message-<?=$value['channel_id']?>"></textarea>	
						<?php endif ?>
					<?php endforeach ?>
					       	 <button style="margin-top: 20px;"  type="submit" class="btn btn-primary">Сохранить</button>
				</div>

			</div>

		</form>
	</div>
	<!-- <a href="/new_offer.php" class="add">+</a> -->





<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Создать оффер</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="add_new_offer" method="POST" action="/actions/add.php"	>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Описание</label>
		    <input required="" name="description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Описание">
		  </div>

			  <?php foreach ($tags as $key => $value): ?>
		  	<p> <input type="checkbox" name="tags-<?=$value['tagid']?>"> <?=$value['tagname']?></p>
		  <?php endforeach ?>


		  <div class="form-group">
		    <label  for="exampleInputEmail1"><input  name="active" type="checkbox"> Активен</label>
		  </div>
		        <div class="modal-footer">
     
        <button type="submit" class="btn btn-primary">Создать</button>
      </div>
		</form>
      </div>
    </div>
  </div>
</div>




<!-- Редактировать оффер -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Редактировать оффер</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="edit_offer_form" method="POST" action="/actions/edit_offer.php">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Описание</label>
		    <input required="" name="description" class="form-control" placeholder="Описание">
		  </div>

		  <?php foreach ($tags as $key => $value): ?>
		  	<p><input class="edit-taggs" data-id='<?=$value['tagid']?>' type="checkbox" name="tags-<?=$value['tagid']?>"> <?=$value['tagname']?></p>
		  <?php endforeach ?>

		  <input type="hidden" name="offer_id">
		  <div class="form-group">
		    <label  for="exampleInputEmail1"><input  name="active" type="checkbox"> Активен</label>
		  </div>
		        <div class="modal-footer">
     
        <button type="submit" class="btn btn-primary">Сохранить</button>
      </div>
		</form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('body .search-input').keyup(function() {
			var id = $(this).data('id');
			var val = $(this).find('input').val().toLowerCase();
			$('body .offer_row td[data-id='+id+']').each(function() {
				if ( $(this).html().toLowerCase().indexOf(val) + 1) {
					$(this).parent().show();
				} else {
					$(this).parent().hide();

				}
			});
		})


		var arr =  JSON.parse('<?= $types?>');
		$('body .offer_row').on('click', function() {
			$("body .message").val('');
			var id = $(this).data('id');
			$('body .offer_id-input').val(id);
			$('.description-edit-span').html( $(this).find('.description_hide').val() );
			arr.forEach(function(currentValue, index) {
				if (currentValue['offer_id'] == id) {
					$("body .message-"+currentValue['channel_id']).val(currentValue['offer_data']);
				}
			}); 
		})
		// Для первого 

		$("body .message").val('');
		var id = '<?= $maxArr[0] ?>';
		$('body .offer_id-input').val(id);
		$('.description-edit-span').html( $('.offer_row[data-id='+id+']').find('.description_hide').val() );
		arr.forEach(function(currentValue, index) {
			if (currentValue['offer_id'] == id) {
				$("body .message-"+currentValue['channel_id']).val(currentValue['offer_data']);
			}
		}); 

		


		$('body .edit-type input').change(function() {
			var id = $(this).parent().data('id');
			$('body .edit-type input').each(function() {
				if ($(this).parent().data('id') != id) {
					$(this).prop('checked',false)
					$('body .message-'+$(this).parent().data('id')).hide();
				} 
			})
			$('body .message-'+id).show();
		})

		$('body .edit_offer_button').on('click', function() {
			var offer_id = $(this).parent().parent().find('.offer_id_hide').val();
			var description = $(this).parent().parent().find('.description_hide').val();
			var active = $(this).parent().parent().find('.active_hide').val();
			var taggs = $(this).parent().parent().find('.taggs_hide').val();

			$('.edit_offer_form input[name=description]').val(description)
			if (active == 't') {
				$('.edit_offer_form input[name=active]').prop('checked', true);
			} else {
				$('.edit_offer_form input[name=active]').prop('checked',false)
			}
			$('body .edit-taggs').prop('checked', false);
			
			try {
			        var taggs_arr = JSON.parse(taggs);

					taggs_arr.forEach(function(currentValue, index) {
						$('body .edit-taggs').each(function() {
							var id = $(this).data('id');
							if (id == currentValue) {
								$(this).prop('checked', true);
							} 
						})
					}); 
			    } catch (e) {
					// 
			    }
		
			


			$('.edit_offer_form input[name=offer_id]').val(offer_id)
		});
	});
</script>
</body>
</html>