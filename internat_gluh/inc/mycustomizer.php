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
    array('default' => '© 2022 ГБОУ КРОЦ Все права защищены.')
  );
  $customizer->add_control('copyright', array(
    'label' => 'Копирайт сайта (copyright ©)',
    'section' => 'section_one',
    'type' => 'text',
  ));
// Настройки соцсетей ==========================================================
$customizer->add_section(
  'section_soc', array(
    'title' => 'Ссылки на соцсети',
    'description' => 'Указываем ссылки в поле',
    'priority' => 10,
  )
);
// Ссылки на соцсети
$customizer->add_setting('soc_fac', 
  array('default' => '')
);
$customizer->add_control('soc_fac', array(
  'label' => 'Ссылка на фейсбук',
  'section' => 'section_soc',
  'type' => 'text',
));
$customizer->add_setting('soc_vk', 
  array('default' => 'https://vk.com/centre_help')
);
$customizer->add_control('soc_vk', array(
  'label' => 'Ссылка на вконтакте',
  'section' => 'section_soc',
  'type' => 'text',
));
$customizer->add_setting('soc_inst', 
  array('default' => 'https://www.instagram.com/accounts/login/?next=/gboy_kroc/')
);
$customizer->add_control('soc_inst', array(
  'label' => 'Ссылка на инстаграм',
  'section' => 'section_soc',
  'type' => 'text',
));
$customizer->add_setting('soc_ok', 
  array('default' => '')
);
$customizer->add_control('soc_ok', array(
  'label' => 'Ссылка на одноклассники',
  'section' => 'section_soc',
  'type' => 'text',
));
$customizer->add_setting('soc_tg', 
  array('default' => 'https://t.me/centre_help')
);
$customizer->add_control('soc_tg', array(
  'label' => 'Ссылка на telegram',
  'section' => 'section_soc',
  'type' => 'text',
));
});