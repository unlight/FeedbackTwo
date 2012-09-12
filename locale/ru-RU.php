<?php if (!defined('APPLICATION')) die();

$Definition['FeedbackTwo.Title'] = 'Обратная связь';
$Definition['Feedback'] = 'Обратная связь';
$Definition['You must enter your name.'] = 'Вы должны ввести свое имя.';
$Definition['You must enter your e-mail (will not be published).'] = 'Вы должны указать свой адрес электронной почты (нигде не публикуется).';
$Definition['Thank you for your message.'] = 'Спасибо за сообщение!';
$Definition['Your Name'] = 'Ваше Имя';
$Definition['Your Email'] = 'Ваш Email';
$Definition['Your Phone'] = 'Ваш телефон';
$Definition['Sender\'s phone number: %s'] = 'Номер телефона отправителя письма: %s';
$Definition['Feedback message'] = 'Текст сообщения';
$Definition['Send Message'] = 'Отправить сообщение';
$Definition['Your message has been sent.'] = 'Ваше сообщение отправлено.';
$Definition['FeedbackTwo.Email.Subject'] = 'Обратная связь {Message.FeedbackID}';
$Definition['FeedbackTwo.Email.Body'] = '
Имя: {User.Name}
Email: {User.Email}
Телефон: {Message.Phone}
Сообщение:
{Message.Message}
';
$Definition['Plugins.FeedbackTwo.To'] = 'Кому';
$Definition['FeedbackTwo.To.Description'] = 'Кому отправить сообщение (можно указать список адресов через запятую).';
$Definition['Plugins.FeedbackTwo.Bcc'] = 'Скрытая копия';
$Definition['FeedbackTwo.Bcc.Description'] = '';
$Definition['Plugins.FeedbackTwo.ChunkID'] = 'Chunk ID';
$Definition['FeedbackTwo.ChunkID.Description'] =
'Примечание: в поле Chunk ID можно ввести <a href="%1$s">номер кусочка</a>, отображаемого перед формой на странице с обратной связью.
Создать кусочек можно <a href="%2$s">здесь</a>.';