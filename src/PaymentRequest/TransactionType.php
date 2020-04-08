<?php

namespace Sepia\Redsys\PaymentRequest;

class TransactionType
{
    const AUTHORIZATION = 0; // Autorización
    const PREAUTHORIZATION = 1; // Preautorización
    const CONFIRMATION = 2; // Confirmación
    const AUTOMATIC_REFUND = 3; // Devolución Automática
    const PAYMENT_REFERENCE = 4; // Pago Referencia
    const RECURRING_TRANSACTION = 5; // Transacción Recurrente
    const SUCCESSIVE_TRANSACTION = 6; // Transacción Sucesiva
    const AUTHENTICATION = 7; // Autenticación
    const CONFIGURE_AUTHENTICATION = 8; // Conf. de Autenticación
    const CANCEL_PREAUTHORIZATION = 9; // Anulación de Preautorización
    const DEFERRED_AUTHORIZATOIN = 'O'; // Autorización en diferido
    const CONFIRM_DEFERRED_AUTHORIZATION = 'P'; // Confirmación de autorización en diferido
    const CANCEL_DEFERRED_AUTHORIZATION = 'Q'; // Anulación de autorización en diferido
    const AUTHORIZATION_INITIAL_DEFERRED_RECURRING = 'R'; // Autorización recurrente inicial diferido
    const AUTHORIZATION_SUCCESSIVE_DEFERRED_RECURRING = 'S'; // Autorización recurrente sucesiva diferido
}
