$(document).ready(function(){
	countUp(countParticipantes); // Contagem de todos os participantes sem filtro
	countUp2(countApresentadores); // Contagem de todos os apresentadores sem filtro
	countUp3(countPayment); // Contagem do valor total de dinheiro arrecadado
	countUp4(countJobs); // Contagem de todos os trabalhos enviados sem filtros
	countUp5(countJobsAccepted); // Contagem de todos os trabalhos aceitos
	countUp6(countJobsDenied); // Contagem de todos os trabalhos negados
	countUp7(countPaymentDone); // Total de pagamentos já pagos/disponíveis
	countUp8(countParticipantsPayed); // Total de participantes com inscrição paga
});