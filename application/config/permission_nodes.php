<?php
/**
 * Permissions configuration file
 * 
 * $permissions[user_type] = 'controller/method' or 'controller/*' for all methods
 * 
 * Example:
 * $permissions[0][] = 'auth/*';
 */
# Permissions [Developer]
$permissions[1][] = 'dash/*';
$permissions[1][] = 'faleconosco/*';
$permissions[1][] = 'payments/*';
$permissions[1][] = 'jobs/*';
$permissions[1][] = 'subscribers/*';
$permissions[1][] = 'reports/*';
$permissions[1][] = 'users/*';

#Implementar funções: Administrador, Secretaria (Fale conosco e consulta de cadastros), Avaliador (Consulta de apresentadores e trabalhos), Financeiro (Consulta de cadastros e pagamentos).

# Permissions [Administrador]
$permissions[2][] = '';

# Permissions [Secretaria]
$permissions[3][] = 'dash/index';
$permissions[3][] = 'faleconosco/*';
$permissions[3][] = 'subscribers/participants';
$permissions[3][] = 'subscribers/ajaxDataTableParticipants';
$permissions[3][] = 'subscribers/presenters';
$permissions[3][] = 'subscribers/ajaxDataTablePresenters';
$permissions[3][] = 'subscribers/ajaxPdf';

# Permissions [Avaliador]
$permissions[4][] = '';

# Permissions [Financeiro]
$permissions[5][] = '';