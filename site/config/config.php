<?php

return [
    'debug'  => true,
    'panel.install' => true,
    'home' => 'home',
    'languages' => true,
    'cache' => [
        'social' => true
    ],
    
    'panel' => [
        'css' => 'public/assets/css/panel.custom.css'
    ],
    'routes' => function ($kirby) {
      return [
          [
              'pattern' => ['booking/(:any)/(:any)'],
              'action' => function ($collection,$id) {
                $host = explode('.',$_SERVER['HTTP_HOST']);
                $test = array_pop($host) == 'test' ? true : false;
                $eq = $test ? ';' : ':';
                return go("booking.json/collection{$eq}{$collection}/id{$eq}{$id}");
              }
          ],
          [
              'pattern' => ['contact.json', 'api/contact', 'api-contact', '(:any)/contact.json'],
              'method'  => 'OPTIONS',
              'action'  => function () {
                  header('Access-Control-Allow-Origin: *');
                  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
                  header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Origin, Accept');
                  return '';
              }
          ],
          [
              'pattern' => ['contact.json', 'api/contact', 'api-contact', '(:any)/contact.json'],
              'method'  => 'GET',
              'action'  => function () {
                  return \Kirby\Http\Response::json([
                      'status'  => 'ready',
                      'message' => 'Contact API endpoint is online and accepting POST requests.'
                  ]);
              }
          ],
          [
              'pattern' => ['contact.json', 'api/contact', 'api-contact', '(:any)/contact.json'],
              'method'  => 'POST',
              'action'  => function () {
                  header('Access-Control-Allow-Origin: *');
                  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
                  header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Origin, Accept');

                  $kirby = kirby();
                  $data  = $kirby->request()->data();

                  // Validation
                  $errors = [];
                  if (empty($data['name']) || strlen(trim($data['name'])) < 2) {
                      $errors['name'] = 'Please enter your name / Prosím zadejte jméno';
                  }
                  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                      $errors['email'] = 'Please enter a valid email / Prosím zadejte platný email';
                  }
                  if (empty($data['message']) || strlen(trim($data['message'])) < 3) {
                      $errors['message'] = 'Please enter your message / Prosím zadejte zprávu';
                  }

                  if (!empty($errors)) {
                      return \Kirby\Http\Response::json([
                          'status'  => 'error',
                          'errors'  => $errors,
                          'message' => 'Please fill in all required fields / Prosím vyplňte všechna povinná pole.'
                      ], 400);
                  }

                  $host = explode('.', $_SERVER['HTTP_HOST'] ?? '');
                  $isTest = (array_pop($host) === 'test') || $kirby->option('debug', false);
                  $recipient = $isTest ? 'jiri.klusak@gmail.com' : $kirby->option('email.recipient', 'jiri.klusak@gmail.com');
                  $sender = $kirby->option('email.sender', 'no-reply@u1.cz');

                  $division = $data['division'] ?? 'General';
                  $name     = $data['name'] ?? '';
                  $company  = $data['company'] ?? '-';
                  $email    = $data['email'] ?? '';
                  $phone    = $data['phone'] ?? '-';
                  $message  = $data['message'] ?? '';
                  $cv_link  = $data['cv_link'] ?? '';

                  $body = "New message from website contact form:\n\n";
                  $body .= "Division / Position: {$division}\n";
                  $body .= "Name: {$name}\n";
                  $body .= "Company: {$company}\n";
                  $body .= "Email: {$email}\n";
                  $body .= "Phone: {$phone}\n";
                  if (!empty($cv_link)) {
                      $body .= "CV / Link: {$cv_link}\n";
                  }
                  $body .= "\nMessage:\n{$message}\n";

                  try {
                      $kirby->email([
                          'from'     => $sender,
                          'to'       => $recipient,
                          'replyTo'  => $email,
                          'subject'  => 'New Contact Inquiry: ' . $name . ' (' . $division . ')',
                          'body'     => $body,
                      ]);

                      return \Kirby\Http\Response::json([
                          'status'  => 'success',
                          'message' => 'Thank you! Your message has been sent.'
                      ]);
                  } catch (\Throwable $e) {
                      if ($isTest) {
                          return \Kirby\Http\Response::json([
                              'status'  => 'success',
                              'message' => 'Thank you! Your message has been sent (Test mode: ' . $recipient . ').',
                              'debug'   => $e->getMessage()
                          ]);
                      }
                      return \Kirby\Http\Response::json([
                          'status'  => 'error',
                          'message' => 'Could not send message: ' . $e->getMessage()
                      ], 500);
                  }
              }
          ],
       
      ];
    },
    'instagram.token.test' => 'IGAARfnJ3rbYlBZAFpJYTEtWTBxUEJvME0tU3lTazhqQU1SZA2xNU0dTeUlkWFF6RS1YeGI5ZAzZACZAFd5VW9jU2FKRGtMTTBwOEdXTzkxTXF2MTNJYW05eDNfNUE1cDRWd2xiblhrMWNnLVdQbi1hSWpISWtfaW5nTS1mc0lPUDNnTQZDZD',
    'instagram.token' => 'IGAARfnJ3rbYlBZAFpvSVZAGSGFLTVFMXzFRUm9kdmlQQzZArS2x6dkFQOUVkWDRDbGJSaWVDOEpXbDFQTldfSWoySkJJd29JNEpWREVweWd5RldwQU9HUV94eTdGeVUtRzJ0TDExVnVzZA2NmdnM2S19uMVlEY21kS2NKQVNZAU1VHSQZDZD',

    'linkedin.org_id' => 'urn:li:organization:18790224',
    'linkedin.token' => 'AQXc40XujSnxksulm1icLv1Sx81FOROFq9Id6NnEOuwYHozxRDdBPyPNjz7ogFt3GckHMTueH4wMdw_JPyQYDPdVMr3T-okjrFy7OX5W8skS7W74G-b4J9jJ7bv2460WQJqnCmERIPny_JKoWMGLnl-F9OF53pOtRZDw42vZ73oWnAYzfz47jVJ3ybFlAGJTXagDO1go_I5IuWaXf9uzSN_7oXYIfM3EMsz_n5HgGEWeVk7H-FJSu9rDpbE4zsyBtipGcPgewVNl1exAytVA_IeAMy1uZMsGLKq0GHFC-T9Z_-l2cOoXPe9CFf8EE5mcvEZJdR2oIPnaCXCd_BV7EKVJBTs1-Q'


    
];

