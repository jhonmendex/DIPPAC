var database = firebase.database();

const getParticipantsByGuardian = (guardian) => {
	const participants = database.ref('participants')
		.orderByChild('guardianUser')
		.equalTo(guardian)
	participants.on('value', function (snapshot) {
		paintTableParticipants(snapshot.val())
	})
}
const creategroupMuestral = (idUSer) => {
	const ref = database.ref("sampleCodes");
	const codguardian = document.getElementById("codigo").value;
	const guardianCode = idUSer + "-" + codguardian;
	var usersRef = ref.child(guardianCode);
	usersRef.set({
		guardianUser: idUSer
	});

	alert('Codigo Guardian generado = ' + guardianCode);
}

const paintTableParticipants = (participantsJson) => {
	const sampleGroups = new Array();
	for (let participantKey in participantsJson) {
		const participant = participantsJson[participantKey];
		const key = `${participant.sampleCode} `;
		if (sampleGroups[key] == undefined)
			sampleGroups[key] = new Array();
		sampleGroups[key].push(participant);
	}
	for (let sampleGroup in sampleGroups) {
		let script = `
		<div class="card">
			<div class="container">
				<table class="table table-borderless table-hover">
					<thead class="thead-main">
						<tr>
							<h2 class="code">${sampleGroup}</h2>
						</tr>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Edad</th>
							<th scope="col">Fecha</th>
							<th scope="col">Promedio</th>
						</tr>
					</thead>
					<tbody>`;
		for (let participantKey in sampleGroups[sampleGroup]) {
			const participant = sampleGroups[sampleGroup][participantKey];
			let date;
			try {
				date = participant.date.date + "/" + (participant.date.month + 1) + "/" + (participant.date.year + 1900)
			} catch (error) {
				date = "19/11/2020"
			};
			const average = getAverage(participant);
			let style = '';
			if (average < 30)
				style = 'class = "dangerous" ';
			script += `<tr ${style}onclick="goToDetail('${participant.id}')">
						<th style="width: 40%;" scope="row"><div class="table-column">${participant.name}</div></th>							
							<td>${participant.age}</td>
							<td>${date}</td>
							<td>${average}</td>
						</tr>`;
		}
		script += `
					</tbody>
				</table>
			</div>
		</div>`;
		document.getElementById('list').insertAdjacentHTML("beforeend", script);
	}
}

const goToDetail = (id) => {
	window.location = `index.php?controlador=Dislexya&accion=testResultDetail&idparticipant=${id}`;
	console.log(id);
}

const getAverage = (participant) => {
	let average = 0;
	try {
		const points = getRangeValuesSevenAge(participant);
		for (let point in points) {
			console.log(`puntos: ${points[point]}`);
			average += ((points[point] + 1) * 10);
		}
		average = (average / 10);
	} catch (e) {
		average = 0;
	}
	return average;
}



// verificacion de las funciones de obtencion de datos
