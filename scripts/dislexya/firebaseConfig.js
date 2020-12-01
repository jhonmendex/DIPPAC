//const
//firebase nodes
const sampleCodes = "sampleCodes";

//user
const user = "sierramorena"; //TODO: falta obtener el valor real del usuario

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
	apiKey: "AIzaSyBESHJ9YOmjFXFNiLY7x3_Qn3haNOokUhM",
	authDomain: "detecgalaxy.firebaseapp.com",
	databaseURL: "https://detecgalaxy.firebaseio.com",
	projectId: "detecgalaxy",
	storageBucket: "detecgalaxy.appspot.com",
	messagingSenderId: "461084404499",
	appId: "1:461084404499:web:37fa7ca6170a5b2469c8e6",
	measurementId: "G-470GBBK0GD"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();