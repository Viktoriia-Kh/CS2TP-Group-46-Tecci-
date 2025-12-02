/* Grabbing The Form And Setting Up The Fields */
const contactForm = document.getElementById("contactForm");
/* 'const contactForm' creates a constant variable called 'contantForm' */
/* 'document.getElementById("contactForm")' looks at the HTML and returns the element with the id="contactForm"' */

const fields = { /* This creates a constant object */
    firstName: {
        input: document.getElementById("firstName"), /* This finds the <input id="firstName"...> element in the HTML and stores it */
        error: document.getElementById("firstNameError"), /* This finds <p class="error-message" id="firstNameError"></p> under that input and is where the error text for the first name will go */
        message: "Please enter your first name.", /* This is the error message text that will be shown if validation fails */
    },
    lastName: { /* This follows the same pattern as firstName */
        input: document.getElementById("lastName"),
        error: document.getElementById("lastNameError"),
        message: "Please enter your last name.",
    },
    phone: { /* This follows the same pattern as firstName */
        input: document.getElementById("phone"),
        error: document.getElementById("phoneError"),
        message: "Please enter a valid phone number.",
    },
    email: { /* This follows the same pattern as firstName */
        input: document.getElementById("email"),
        error: document.getElementById("emailError"),
        message: "Please enter a valid email address.",
    },
    message: { /* This follows the same pattern as firstName */
        input: document.getElementById("message"),
        error: document.getElementById("messageError"),
        message: "Please enter your query.",
    },
};

const successMessage = document.getElementById("formSuccessMessage");
/* This finds <p class="success-message" id="formSuccessMessage"></p> and stores it in a variable called successMessage, this is where the Success Message will be displayed */

/* Helper Functions */
function clearErrors() { /* This declares a named function */
    Object.values(fields).forEach(({ input, error }) => { /* This will take the fields objects and run an array of its values, loops through each field object */
        input.classList.remove("input-error"); /* This means that if the field had the input-error class/red border, it will remove it */
        error.textContent = ""; /* This removes any existing error text */
    });
    successMessage.textContent = ""; /* This makes sure each new attempt starts fresh after clearing all field errors, or any existing success text */
}

function validateEmail(value) { /* This function checks if an email string looks like a valid email format */
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; /* This defines a regular expression pattern for email */
    return emailPattern.test(value); /* This applies the expression pattern to the string, and returns true if it matches, but returns false if it doesn't */
}

function validatePhone(value) { /* This function checks if the phone number follows a simple pattern */
    const phonePattern = /^[0-9+\s()\-]{7,}$/; /* This defines a regular expression pattern for phone */
    return phonePattern.test(value); /* This will return true if the phone number matches, and false if it doesn't */
}

/* Submit Event Listener */
contactForm.addEventListener("submit", function (event) { /* '.addEventListener("submit"...)' waits until the user clicks the submit button */
    /* 'function (event)' is the function that runs when the form is submitted */
    clearErrors(); /* This calls clearErrors() to make sure no previous error messages/red borders remain from other submissions from before */
    let isValid = true; /* This decides whether the submission is valid or not */

    /* First name */
    if (!fields.firstName.input.value.trim()) { /* This gets the text that the user typed into the first name field, 'trim()' removes spaces from the start and end */
        fields.firstName.input.classList.add("input-error"); /* If the trimmed value is empty, show an error, so this adds the red border to this input */
        fields.firstName.error.textContent = fields.firstName.message; /* If the trimmed value is empty, show an error, so this shows 'Please enter your first name' */
        isValid = false; /* This flags that something is wrong with the form */
    }

    /* Last name */
    if (!fields.lastName.input.value.trim()) { /* This uses the same logic as the first name field */
        fields.lastName.input.classList.add("input-error");
        fields.lastName.error.textContent = fields.lastName.message;
        isValid = false;
    }

    /* Phone */
    if (!fields.phone.input.value.trim() || !validatePhone(fields.phone.input.value.trim())) {
        /* There are two conditions: If the phone is empty, or if the phone field is not empty but the expression pattern fails */
        fields.phone.input.classList.add("input-error");
        fields.phone.error.textContent = fields.phone.message;
        isValid = false;
    }

    /* Email */
    if (!fields.email.input.value.trim() || !validateEmail(fields.email.input.value.trim())) { /* This uses same logic as the phone field */
        fields.email.input.classList.add("input-error");
        fields.email.error.textContent = fields.email.message;
        isValid = false;
    }

    /* Message */
    if (!fields.message.input.value.trim()) { /* Same logic as the first name field */
        fields.message.input.classList.add("input-error");
        fields.message.error.textContent = fields.message.message;
        isValid = false;
    }

    /* Decision To Submit Or Block The Form */
    if (!isValid) { /* If 'isValid' is false, it means that at least one field failed */
        event.preventDefault(); /* This stops the form from submitting if there are errors */
    } else {
    }
});


