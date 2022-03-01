<?
add_action('customize_register', function($customizer) {
	$customizer->add_section(
		'section_one', array(
			'title' => 'Настройки сайта',
			'description' => 'При добавлении нескольких значений в поле, пишите через запяту пример (+79288008080,+79299009090)',
			'priority' => 11,
		)
	);

  // телефон 1
	$customizer->add_setting('phones', 
		array('default' => '88004444245')
	);
	$customizer->add_control('phones', array(
    'label' => 'Телефон(ы)',
    'section' => 'section_one',
    'type' => 'textarea',
  ));
  // Е-почта флексопечать
  $customizer->add_setting('email', 
    array('default' => 'internat123@mon.alania.gov.ru')
  );
  $customizer->add_control('email', array(
    'label' => 'Е-почта',
    'section' => 'section_one',
    'type' => 'text',
  ));
  
  // адрес
  $customizer->add_setting('address', 
		array('default' => '362015, Республика Северная Осетия - Алания, г. Владикавказ, улица Грибоедова, д.1')
	);
	$customizer->add_control('address', array(
    'label' => 'Адрес',
    'section' => 'section_one',
    'type' => 'text',
	));
  // копирайт сайта
  $customizer->add_setting('copyright', 
    array('default' => '© 2021 «ЮГ-Телеком» Все права защищены.')
  );
  $customizer->add_control('copyright', array(
    'label' => 'Копирайт сайта (copyright ©)',
    'section' => 'section_one',
    'type' => 'text',
  ));

});