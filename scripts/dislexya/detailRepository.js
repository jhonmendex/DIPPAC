var database = firebase.database();

const getParticipantById = (id) => {
    const participant = database.ref(`participants/${id}`);
    participant.on('value', function (snapshot) {
        // console.log(snapshot.val());
        //console.log(snapshot.val());
        mainDetail(snapshot.val());
        //ser();
        barGraphicScored(snapshot.val());
        barGraphicTime(snapshot.val());
    })
}