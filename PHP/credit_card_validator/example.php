<?php

  require_once 'ccvalidator.class.php';

  $ccv = new CCValidator('JOHN JOHNSON', CCV_AMERICAN_EXPRESS, '378282246310001', 3, 2012);

  if ($validCard = $ccv->validate())
  {

    if ($validCard & CCV_RES_ERR_HOLDER)
    {
      echo 'Card holder\'s name is missing or incorrect.<br />';
    }

    if ($validCard & CCV_RES_ERR_TYPE)
    {
      echo 'Incorrect credit card type.<br />';
    }

    if ($validCard & CCV_RES_ERR_DATE)
    {
      echo 'Incorrect expiration date.<br />';
    }

    if ($validCard & CCV_RES_ERR_FORMAT)
    {
      echo 'Incorrect credit card number format.<br />';
    }

    if ($validCard & CCV_RES_ERR_NUMBER)
    {
      echo 'Invalid credit card number.<br />';
    }

  }
  else
  {
    echo 'Credit card information is valid.<br />';
  }

?>