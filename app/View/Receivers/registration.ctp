<?php 
	echo $this->Form->create('Receiver');
	echo $this->Form->label('Receiver.last_name_1', '氏');
	echo $this->Form->text('Receiver.last_name_1');
	echo $this->Form->label('Receiver.first_name_1', '名');
	echo $this->Form->text('Receiver.first_name_1');
	echo $this->Form->label('Receiver.last_name_2', '氏');
	echo $this->Form->text('Receiver.last_name_2');
	echo $this->Form->label('Receiver.first_name_2', '名');
	echo $this->Form->text('Receiver.first_name_2');
	echo $this->Form->label('Receiver.zip_code', '郵便番号');
	echo $this->Form->text('Receiver.zip_code');
	echo $this->Form->label('Receiver.address', '住所');
	echo $this->Form->text('Receiver.address');
	echo $this->Form->label('Receiver.tel', '電話番号');
	echo $this->Form->text('Receiver.tel');
	echo $this->Form->end('登録');
?>