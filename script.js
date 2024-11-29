// Function to check if the user is logged in using fetch API
function checkLoginStatus() {
  fetch("./backend/auth.php")
    .then((response) => response.text())
    .then((data) => {
      // Check the response from the server
      if (data === "User is not logged in") {
        alert("session ended please login");
        setTimeout(() => {
          window.location.href = "./index.html";
        }, 400);
      }
    })
    .catch((error) => {
      alert("Error: " + error);
    });
}

window.onload = checkLoginStatus;

//function to open form
function openForm(formType) {
  document.getElementById(`${formType}Form`).style.display = "block";
}
//function to close form
function closeForm(formType) {
  document.getElementById(`${formType}Form`).style.display = "none";
}

//function to add doctors
function addDoctor() {
  const firstName = document.getElementById("firstName").value;
  const lastName = document.getElementById("lastName").value;
  const email = document.getElementById("email").value;
  const dob = document.getElementById("dob").value;
  const phone = document.getElementById("phone").value;
  const department = document.getElementById("department").value;

  // Create a FormData object to send the form data
  const formData = new FormData();
  formData.append("firstName", firstName);
  formData.append("lastName", lastName);
  formData.append("email", email);
  formData.append("dob", dob);
  formData.append("phone", phone);
  formData.append("department", department);

  // Make an AJAX request using fetch
  fetch("./backend/doctors/doctor.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Parse response as text
    .then((data) => {
      // Display success or failure message
      alert(data);
      loadDoctors();
      document.querySelector(".form-container").reset();
      closeForm("doctor");
    })
    .catch((error) => {
      alert("Error: " + error);
    });
}

//code to get doctors
function loadDoctors() {
  fetch("./backend/doctors/get_doctors.php") // Adjust path if needed
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      if (data.error) {
        alert(data.error); // Handle errors like "User not logged in"
        return;
      }

      // Clear existing rows
      const doctorTable = document.getElementById("doctorTable");
      doctorTable.innerHTML = "";

      // Populate the table with fetched doctor data
      data.forEach((doctor) => {
        const row = doctorTable.insertRow();
        row.innerHTML = `
                    <td>${doctor.first_name} ${doctor.last_name}</td>
                    <td>${doctor.email}</td>
                    <td>${doctor.date_of_birth}</td>
                    <td>${doctor.phone}</td>
                    <td>${doctor.department}</td>
                    <td>
                        <button onclick="deleteDoctor(${doctor.id}, this)">Delete</button>
                         <button onclick="editDoctor('${doctor.first_name}')">Edit</button>

                    </td>
                `;
      });
    })
    .catch((error) => {
      alert("Error fetching doctors: " + error);
    });
}

if (window.location.pathname.endsWith("doctors.html")) {
  // Fetch and display all doctors
  loadDoctors();
}

// Function to delete a doctor (to be implemented)
function deleteDoctor(doctorId, button) {
  if (confirm("Are you sure you want to delete this doctor?")) {
    fetch("./backend/doctors/delete_doctor.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: doctorId }),
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "Doctor deleted successfully") {
          // Remove the doctor row from the table
          const row = button.closest("tr");
          row.parentNode.removeChild(row);
        } else {
          alert("Error deleting doctor: " + data);
        }
      })
      .catch((error) => {
        alert("Error: " + error);
      });
  }
}

// Function to edit a doctor (to be implemented)
function editDoctor(doctorFirstname) {
  alert(
    "Edit functionality for doctor " + doctorFirstname + " to be implemented."
  );
}

//function to add patients
function addPatients() {
  const firstName = document.getElementById("firstName").value;
  const lastName = document.getElementById("lastName").value;
  const address = document.getElementById("address").value;
  const email = document.getElementById("email").value;
  const dob = document.getElementById("dob").value;
  const phone = document.getElementById("phone").value;
  const patient_doctor = document.getElementById("patient-doctor").value;

  // Create a FormData object to send the form data
  const formData = new FormData();
  formData.append("firstName", firstName);
  formData.append("lastName", lastName);
  formData.append("address", address);
  formData.append("email", email);
  formData.append("dob", dob);
  formData.append("phone", phone);
  formData.append("patient_doctor", patient_doctor);

  // Make an AJAX request using fetch
  fetch("./backend/patients/patient.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Parse response as text
    .then((data) => {
      // Display success or failure message
      alert(data);
      loadPatients();
      document.querySelector(".form-container").reset();

      closeForm("patient");
    })
    .catch((error) => {
      alert("Error: " + error);
    });
}

function loadPatients() {
  fetch("./backend/patients/get_patient.php") // Adjust path if needed
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      if (data.error) {
        alert(data.error); // Handle errors like "User not logged in"
        return;
      }

      // Clear existing rows
      const patientTable = document.getElementById("patientTable");
      patientTable.innerHTML = "";
      // Populate the table with fetched doctor data
      data.forEach((patient) => {
        const row = patientTable.insertRow();
        row.innerHTML = `
                    <td>${patient.first_name} ${patient.last_name}</td>
                    <td>${patient.address}</td>
                    <td>${patient.email}</td>
                    <td>${patient.date_of_birth}</td>
                    <td>${patient.phone}</td>
                    <td>${patient.doctor}</td>
                    <td>
                        <button onclick="deletePatient(${patient.id}, this)">Delete</button>
                         <button onclick="editPatient('${patient.first_name}')">Edit</button>

                    </td>
                `;
      });
    })
    .catch((error) => {
      alert("Error fetching patients: " + error);
    });
}

if (window.location.pathname.endsWith("patients.html")) {
  // Fetch and display all doctors
  loadPatients();
}

function deletePatient(patientId, button) {
  if (confirm("Are you sure you want to delete this patient?")) {
    fetch("./backend/patients/delete_patient.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: patientId }),
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "Patient deleted successfully") {
          // Remove the doctor row from the table
          const row = button.closest("tr");
          row.parentNode.removeChild(row);
        } else {
          alert("Error deleting patient: " + data);
        }
      })
      .catch((error) => {
        alert("Error: " + error);
      });
  }
}

function editPatient(patientFirstname) {
  alert(
    "Edit functionality for patient " + patientFirstname + " to be implemented."
  );
}

function addAppointment() {
  const appoint = document.getElementById("appoint").value;
  const name = document.getElementById("name").value;
  const doc = document.getElementById("doc").value;
  const dept = document.getElementById("dept").value;
  const date = document.getElementById("date").value;
  const time = document.getElementById("time").value;

  // Create a FormData object to send the form data
  const formData = new FormData();
  formData.append("appointment_id", appoint);
  formData.append("patientName", name);
  formData.append("doctorName", doc);
  formData.append("departmentName", dept);
  formData.append("appointment_date", date);
  formData.append("appointment_time", time);

  // Make an AJAX request using fetch
  fetch("./backend/appointments/appointment.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Parse response as text
    .then((data) => {
      // Display success or failure message
      alert(data);
      loadAppointments();
      document.querySelector(".form-container").reset();

      closeForm("appoint");
    })
    .catch((error) => {
      alert("Error: " + error);
    });
}
function loadAppointments() {
  fetch("./backend/appointments/get_appointment.php") // Adjust path if needed
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      if (data.error) {
        alert(data.error); // Handle errors like "User not logged in"
        return;
      }

      // Clear existing rows
      const appointTable = document.getElementById("appointTable");
      appointTable.innerHTML = "";
      // Populate the table with fetched doctor data
      data.forEach((appointment) => {
        const row = appointTable.insertRow();
        row.innerHTML = `
                    <td>${appointment.id} </td> 
                    <td> ${appointment.patient}</td>
                    <td>${appointment.doctor}</td>
                    <td>${appointment.departmentName}</td>
                    <td>${appointment.appointment_date}</td>
                    <td>${appointment.appointment_time}</td>
                    <td>
                        <button onclick="deleteAppointment(${appointment.id}, this)">Delete</button>
                         <button onclick="editAppointment(${appointment.id})">Edit</button>

                    </td>
                `;
      });
    })
    .catch((error) => {
      alert("Error fetching appointments: " + error);
    });
}

if (window.location.pathname.endsWith("appointment.html")) {
  // Fetch and display all doctors
  loadAppointments();
}

function deleteAppointment(appointmentId, button) {
  if (confirm("Are you sure you want to delete this appointment?")) {
    fetch("./backend/appointments/delete_appointment.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: appointmentId }),
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "Appointment deleted successfully") {
          // Remove the doctor row from the table
          const row = button.closest("tr");
          row.parentNode.removeChild(row);
        } else {
          alert("Error deleting appointment: " + data);
        }
      })
      .catch((error) => {
        alert("Error: " + error);
      });
  }
}

function editAppointment(appointmentId) {
  alert(
    "Edit functionality for appointment " +
      appointmentId +
      " to be implemented."
  );
}

function addDepartment() {
  const name = document.getElementById("name").value;
  const des = document.getElementById("des").value;

  // Create a FormData object to send the form data
  const formData = new FormData();
  formData.append("department_name", name);
  formData.append("description", des);

  // Make an AJAX request using fetch
  fetch("./backend/departments/department.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Parse response as text
    .then((data) => {
      // Display success or failure message
      alert(data);
      loadDepartment();
      document.querySelector(".form-container").reset();

      closeForm("dept");
    })
    .catch((error) => {
      alert("Error: " + error);
    });
}

function loadDepartment() {
  fetch("./backend/departments/get_department.php") // Adjust path if needed
    .then((response) => response.json()) // Parse JSON response
    .then((data) => {
      if (data.error) {
        alert(data.error); // Handle errors like "User not logged in"
        return;
      }

      // Clear existing rows
      const deptTable = document.getElementById("deptTable");
      deptTable.innerHTML = "";
      // Populate the table with fetched doctor data
      data.forEach((department) => {
        const row = deptTable.insertRow();
        row.innerHTML = `
                    <td>${department.department_name} </td> 
                    <td> ${department.description}</td>
                    <td>
                        <button onclick="deleteDepartment(${department.id}, this)">Delete</button>
                         <button onclick="editDepartment('${department.department_name}')">Edit</button>

                    </td>
                `;
      });
    })
    .catch((error) => {
      alert("Error fetching appointments: " + error);
    });
}

if (window.location.pathname.endsWith("department.html")) {
  // Fetch and display all doctors
  loadDepartment();
}

// Function to delete department
function deleteDepartment(departmentId, button) {
  if (confirm("Are you sure you want to delete this department?")) {
    fetch("./backend/departments/delete_department.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: departmentId }),
    })
      .then((response) => {
        console.log("Response status:", response.status); // Debugging response status
        return response.text();
      })
      .then((data) => {
        console.log("Response data:", data); // Debugging backend output
        if (data.trim() === "Department deleted successfully") {
          alert("Department deleted successfully"); // Alert should display here
          // Remove the department row from the table
          const row = button.closest("tr");
          n;
          row.parentNode.removeChild(row);
        } else {
          alert("Error deleting Department: " + data);
        }
      })
      .catch((error) => {
        alert("Error: " + error);
      });
  }
}

function editDepartment(departmentName) {
  alert(
    "Edit functionality for department " +
      departmentName +
      " to be implemented."
  );
}
function deleteRow(btn) {
  const row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

//alert for logging out
document.getElementById("logout-btn").addEventListener("click", function () {
  // Create the alert div element dynamically
  const alertBox = document.createElement("div");

  alertBox.style.position = "fixed";
  alertBox.style.top = "0";
  alertBox.style.left = "50%";
  alertBox.style.transform = "translateX(-50%)";
  alertBox.style.backgroundColor = "#f44336";
  alertBox.style.color = "white";
  alertBox.style.padding = "15px 30px";
  alertBox.style.fontSize = "16px";
  alertBox.style.fontWeight = "bold";
  alertBox.style.borderRadius = "5px";
  alertBox.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
  alertBox.style.zIndex = "1000";
  alertBox.style.textAlign = "center";
  alertBox.style.width = "auto";
  alertBox.style.maxWidth = "500px";
  alertBox.style.transition = "top 0.3s ease";
  alertBox.innerText = "Logging out..."; // The message

  document.body.appendChild(alertBox);

  // Send the logout request
  fetch("./backend/logout.php", {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      if (data === "Logged out successfully") {
        // Show the alert
        alertBox.style.backgroundColor = "#4CAF50";
        alertBox.innerText = "Logging out...";

        setTimeout(() => {
          alertBox.style.top = "-100px";
          setTimeout(() => {
            alertBox.style.display = "none";
            window.location.href = "./index.html";
          }, 400); // Wait for transition to finish before hiding the box
        }, 800); // Wait 1 second before starting to slide the box out
      } else {
        alertBox.innerText = "Logout failed! Please try again.";
        alertBox.style.backgroundColor = "#f44336";
        setTimeout(() => {
          alertBox.style.top = "-100px";
          setTimeout(() => {
            alertBox.style.display = "none";
          }, 300);
        }, 2000);
      }
    })
    .catch((error) => {
      alertBox.innerText = "Error: " + error;
      alertBox.style.backgroundColor = "#f44336";
      setTimeout(() => {
        alertBox.style.top = "-100px";
        setTimeout(() => {
          alertBox.style.display = "none";
        }, 300);
      }, 2000);
    });
});

//dashboard/home implement
function fetchDashboardData() {
  document.addEventListener("DOMContentLoaded", () => {
    fetch("./backend/dashboard/home.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          alert(data.error);
          return;
        }

        console.log("Dashboard Data:", data); // Debugging

        // Update total counts
        document.querySelector(".cards .card:nth-child(1) h1").innerText =
          data.totals.doctors;
        document.querySelector(".cards .card:nth-child(2) h1").innerText =
          data.totals.patients;
        document.querySelector(".cards .card:nth-child(3) h1").innerText =
          data.totals.appointments;
        document.querySelector(".cards .card:nth-child(4) h1").innerText =
          data.totals.departments;

        // Update recent patients
        const patientList = document.querySelector(".patients");
        if (!patientList) {
          console.error("Missing '.patients' container in HTML.");
          return;
        }
        patientList.innerHTML += "<ol></ol>";
        const olPatients = patientList.querySelector("ol");
        Object.assign(olPatients.style, {
          margin: "20px 0",
          paddingLeft: "20px",
          fontFamily: "'Arial', sans-serif",
          fontSize: "16px",
        });

        data.patients.forEach((patient) => {
          const patientItem = document.createElement("li");
          patientItem.innerText = patient;
          Object.assign(patientItem.style, {
            marginBottom: "10px",
            padding: "5px",
            borderBottom: "1px solid #ccc",
            transition: "color 0.3s ease, background-color 0.3s ease",
          });
          olPatients.appendChild(patientItem);
        });

        // Update doctors
        const doctorList = document.querySelector(".doc");
        if (!doctorList) {
          console.error("Missing '.doc' container in HTML.");
          return;
        }
        doctorList.innerHTML += "<ol></ol>";
        const olDoctors = doctorList.querySelector("ol");
        Object.assign(olDoctors.style, {
          margin: "20px 0",
          paddingLeft: "20px",
          fontFamily: "'Arial', sans-serif",
          fontSize: "16px",
        });

        data.doctors.forEach((doctor) => {
          const doctorItem = document.createElement("li");
          doctorItem.innerText = doctor;
          Object.assign(doctorItem.style, {
            marginBottom: "10px",
            padding: "5px",
            borderBottom: "1px solid #ccc",
            transition: "color 0.3s ease, background-color 0.3s ease",
          });
          olDoctors.appendChild(doctorItem);
        });
      })
      .catch((error) => {
        console.error("Error fetching dashboard data:", error);
        alert("Error fetching dashboard data: " + error);
      });
  });
}

// Load data when the page loads
if (window.location.pathname.endsWith("home.html")) {
  // Fetch and display all doctors
  fetchDashboardData();
}
