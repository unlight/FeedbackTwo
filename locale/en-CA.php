<?php if (!defined('APPLICATION')) die();

$Definition['FeedbackTwo.Title'] = 'Feedback';
$Definition['Feedback'] = 'Feedback';
$Definition['You must enter your name.'] = 'You must enter your name.';
$Definition['You must enter your e-mail (will not be published).'] = 'You must enter your e-mail (will not be published).';
$Definition['Feedback by %s %s'] = 'Feedback by %s %s';
$Definition['Thank you for your message.'] = 'Thank you for your message.';
$Definition['Your Name'] = 'Your Name';
$Definition['Your Email'] = 'Your Email';
$Definition['Feedback message'] = 'Message';
$Definition['Send Message'] = 'Send Message';
$Definition['Your message has been sent.'] = 'Your message has been sent.';
$Definition['FeedbackTwo.Email.Subject'] = 'Feedback {Message.FeedbackID}';
$Definition['FeedbackTwo.Email.Body'] = '
Name: {User.Name}
Email: {User.Email}
Phone: {Message.Phone}
Message:
{Message.Message}
';
$Definition['Plugins.FeedbackTwo.To'] = 'To';
$Definition['FeedbackTwo.To.Description'] = 'Who will receive the message (you may separate several emails by comma).';
$Definition['Plugins.FeedbackTwo.Bcc'] = 'Bcc (blind carbon copy)';
$Definition['FeedbackTwo.Bcc.Description'] = '';
$Definition['Plugins.FeedbackTwo.ChunkID'] = 'Chunk ID';
$Definition['FeedbackTwo.ChunkID.Description'] =
'Note: In field Chunk ID you may enter <a href="%1$s">ID of chunk</a>, this chunk will be showed before feedback form.
You can create chunk <a href="%2$s">here</a>.';