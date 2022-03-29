@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container-fluid">
	<div class="row" style="background-image: url(https://via.placeholder.com/1500x400/2C2C2C/2C2C2C);">
		<div class="col-md-12 p-5">
			<div class="row">
				<div class="col-md-12 d-flex justify-content-center">
					<h1 class="white">Reglamento <span style="color: #ff9900"> oficial</span></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<h4 class="white"><strong><u>Reglas generales</u></strong></h4>
					<p class="about-text">
						<ol class="white about-text">
							<li>Se requiere ser mayor de edad para participar, es obligatorio tener el perfil de Steam público y cuenta en faceit para poder participar. Se admiten todos los niveles de habilidad.</li>
							<li>Los jugadores deben estar presentes a no menos de 20 minutos de la hora programada para el partido, esto a fin de evitar interrupciones y retrasos.</li>
							<li>Los jugadores deben estar presentes en el servidor a jugar en no menos de 5 minutos del partido.</li>
							<li>Los jugadores deben mantener un comportamiento profesional y respetuoso en todo momento.</li>
							<li>Solo se permiten mensajes en el chat relacionados con el juego.</li>
							<li>Todas las opiniones, valoraciones, propuestas y mejoras son bienvenidas, siempre que se hagan con este respeto y educación.</li>
							<li>De no haber un mínimo de 16 equipos, es posible que se modifiquen las fases del torneo o se actualicen los premios.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Configuraciones del juego</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Rondas: MR15</li>
							<li>Tiempo de ronda: 1:55 minutos</li>
							<li>Tiempo de congelación: 20 segundos</li>
							<li>Tiempo de compra: 20 segundos</li>
							<li>Temporizador del C4: 40 segundos</li>
							<li>Dinero en el overtime: $10.000</li>
							<li>Rondas en el overtime: MR3</li>
							<li>En el caso de los mapas BO3 los equipos tendrán 10 minutos de descanso entre mapa y mapa</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Formato de grupos</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>El torneo está formado por una fase de grupos formado por 4 grupos de 4 equipos que disputarán partidos entre sí, los dos mejores de cada equipo procederán a la fase eliminatoria, el mejor de cada equipo podrá elegir su primer rival del otro grupo.</li>
							<li>El formato aceptará entre 16 a 32 equipos, variando porcentualmente según la cantidad de inscriptos.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Formato de eliminatorias</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>El formato de la fase eliminatoria se regirá por una llave superior y una llave inferior, ósea un formato de doble eliminación, con posibilidad de redención.</li>
							<li>El formato aceptará entre 8 a 16 equipos, variando porcentualmente según la cantidad de inscriptos.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Mapas</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>
								Grupo de mapas
								<ol type="a">
									<li>Dust 2</li>
									<li>Inferno</li>
									<li>Mirage</li>
									<li>Nuke</li>
									<li>Overpass</li>
									<li>Train</li>
									<li>Vertigo</li>
								</ol>
							</li>
							<li>Cada partido se jugará en formato Best Of 1 (BO1) exceptuando los partidos de la final de la llave superior, la final de la llave inferior, la final de consolidación y la final de la copa que se jugarán en formato Best Of 3 (BO3).</li>
							<li>La fase de elección de mapas deberá hacerse al menos una hora antes de la hora programada para el partido.</li>
							<li>
								En la fase de elección de mapas para el formato BO3 se proseguirá así:
								<ol type="a">
									<li>El oficial del partido lanzará una moneda, los dos equipos elegirán un lado y el ganador elegirá quien vetará el primer mapa</li>
									<li>Equipo A veta mapa 1</li>
									<li>Equipo  B veta mapa 2</li>
									<li>Equipo A elige mapa 3 - Equipo B elige el lado inicial</li>
									<li>Equipo B elige mapa 4 - Equipo A elige el lado inicial</li>
									<li>Equipo A veta mapa 5</li>
									<li>Equipo B veta mapa 6</li>
									<li>Por lo tanto el mapa 7 quedará como decisivo si fuera necesario, una ronda de cuchillos decidirá el lado inicial exceptuando los partidos donde se enfrenta un equipo de la llave superior con uno de la llave inferior, en ese caso elegirá el lado el de la llave superior.</li>
								</ol>
							</li>
							<li>En la fase de elección de mapas para el formato BO1 simplemente se vetara de manera intercalada entre los dos equipos.</li>
							<li>Tanto en el formato BO3 como el BO1 el equipo que no elija el mapa podrá elegir el bando (CT o TT).</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Estructura de equipos</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Se deberán inscribir cinco jugadores titulares y opcionalmente hasta dos suplentes además de un entrenador.</li>
							<li>Cada equipo designará  a un jugador como capitán, tales capitanes funcionarán como punto de contacto entre el equipo y los oficiales del partido. El papel del capitán se basará entre otras cosas en representar a su equipo y comunicarse con los oficiales del partido; comunicarse con otros capitanes de equipo; actuando como la autoridad final en las decisiones de su equipo; comunicando información del torneo a su equipo</li>
							<li>Los nombres y logos de los equipos no pueden tener contenido ofensivo de ningún tipo. Esto incluye pero no se limita a: insultos, contenido sexual, racismo/xenofobia/homofobia, temas políticos/religiosos y controversiales en general.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Comunicaciones</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Los equipos deben utilizar el Discord proporcionado por la organización, dicho Discord podrá ser grabado y moderado solo para casos de suma importancia, dicho esto nunca contendrá ninguna comunicación táctica o estratégica.</li>
							<li>Un organizador podrá unirse a la comunicación para moderación o soporte tanto técnico como general.</li>
							<li>Solo los cinco jugadores y el entrenador serán permitidos dentro de la llamada.</li>
							<li>Los entrenadores pueden comunicarse con los jugadores de su equipo en cualquier momento durante el partido.</li>
							<li>En el caso de problemas técnicos de cualquier índole los equipos tendrán un canal de texto para comunicarse con la organización. De ser posible se forzará que tal comunicación sea a través del capitán.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Fixtures y administración de partidos</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Todos los partidos serán organizados tan pronto como sea razonablemente posible</li>
							<li>La organización se reserva el derecho absoluto de modificar o postergar la hora de inicio del partido previamente pactada.</li>
							<li>En la fase de grupos los partidos serán impostergables por lo cual se podrá pedir en casos de emergencia la aceptación de un jugador fuera del plantel, este pedido será analizado por todos los organizadores y quedará en sus manos y buena fe la decisión de aceptar o rechazar tal.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Partidos abandonados</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Si un equipo desea perder o no presentarse a un partido, por cualquier motivo, debe realizar una solicitud formal a la organización.</li>
							<li>La organización podrá aceptar o rechazar este pedido, optando las condiciones que se vean apropiadas y confiando en la decisión y buena fe de la organización.</li>
							<li>Si un equipo no actúa de acuerdo con el proceso establecido en este reglamento, o no actúa de acuerdo con cualquier decisión tomada por la organización, la organización puede imponer las sanciones o penas que estime oportunas, teniendo en cuenta la circunstancias.</li>
							<li>Si el oficial del partido considera necesario abandonar un partido, independientemente del número de rondas, mapas jugados o el estado del partido entonces el estado y la puntuación del partido será determinado por la organización, también la organización se reserva el derecho de ordenar que se vuelva a jugar el partido.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Problemas durante un partido</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Si un partido se interrumpe por motivos ajenos al control de los equipos (por ejemplo, problemas del jugador; caída del servidor; cortes de red) la organización puede decidir volver a jugar el partido de acuerdo con los siguientes términos y condiciones:</li>
							<li>Si un problema o cuestión tiene lugar antes de la primera muerte de cualquier ronda, la ronda se volverá a jugar.</li>
							<li>Si un problema o cuestión tiene lugar durante una Ronda, y el resultado de esa ronda se puede determinar, la ronda no se volverá a jugar. Si el resultado no se puede determinar la ronda no se repetirá a menos que la organización llegue a una decisión diferente, los equipos están obligados a continuar la ronda si surge algún problema o problema, hasta que sean informados de lo contrario</li>
							<li>A cada equipo se le permitirán cuatro pausas tácticas por partido cada una con una duración de un minuto y medio.</li>
							<li>Para iniciar una pausa táctica, el capitán del equipo debe hacerlo con el comando “!pause”.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Problemas después del partido</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>Si un equipo considera que es víctima de violaciones a las reglas o una infracción al reglamento durante un partido, el equipo, o cualquiera de sus jugadores, debe jugar el partido hasta el final (ellos no deben bajo ninguna circunstancia detener el partido). Una vez finalizado el partido, el capitán del equipo puede hacer una solicitud a la organización para abrir una investigación. El capitán del equipo puede proporcionar información y pruebas relevantes a la organización para ayudar con la investigación, después de cuya conclusión la organización hará una respuesta y decisión.</li>
							<li>Los equipos que hagan un uso injustificado y/o repetitivo del derecho previsto en virtud de este reglamento puede ser sancionado por la organización.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Abuso de bugs y programas externos</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>
								Están prohibidos los siguientes comandos/opciones de lanzamiento
								<ol type="a">
									<li>mat_hdr_enabled</li>
									<li>+mat_hdr_enabled 0/1</li>
									<li>+mat_hdr_leven 0/1/2</li>
								</ol>
							</li>
							<li>
								Están prohibidos los siguientes scripts/binds
								<ol type="a">
									<li>Stop shoot scripts (Use o AWP scripts)</li>
									<li>Center view scripts</li>
									<li>Turn scripts (180° o similar)</li>
									<li>No recoil scripts</li>
									<li>Burst fire scripts</li>
									<li>Rate changers (Lag scripts)</li>
									<li>FPS scripts</li>
									<li>Anti-flash scripts o binding (snd_* bindings)</li>
									<li>Bunnyhop scripts</li>
									<li>Stop Sound scripts</li>
								</ol>
							</li>
							<li>Está prohibido cualquier tipo de programa adicional, lo que incluye, entre otros, programas A3D que interactúan en forma directa con la calidad del juego, tanto a nivel de audio como visual. Esto también incluye modificaciones a las unidades gráficas.</li>
							<li>La organización revisará y penalizará el uso intencional de bugs, glitches o errores en el juego. Si la organización considera que los bugs afectaron el resultado de una ronda o juego, pueden otorgar rondas o bien, en algunos casos particulares, revocar el resultado. Queda a criterio del oficial del partido considerar si el uso de los mencionados bugs afectó el juego y si otorgará o no rondas o el partido al equipo oponente, o bien forzar un nuevo partido.</li>
						</ol>
					</p>
					<h4 class="white"><strong><u>Otras penalizaciones</u></strong></h4>
					<p>
						<ol class="white about-text">
							<li>No está permitido hacer streaming de las partidas, puesto que el torneo lo transmitiremos en los canales oficiales de la comunidad. Si está permitido grabar las partidas para subirlas a las redes una vez terminadas las mismas.</li>
							<li>Perder de manera intencional un partido implica la descalificación del torneo, a diferencia de rendirse que sí está permitido en nuestro formato.</li>
							<li>Además de los anteriores apartados, serán motivo de sanción las siguientes acciones:</li>
							<li>Spam/Flood en cualquier canal del torneo.</li>
							<li>Venta de productos o servicios.</li>
							<li>Reportes sin motivo o abuso de tickets y menciones a los administradores.</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

@include('includes.footer')
@endsection