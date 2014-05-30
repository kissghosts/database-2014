function signin_form_hash(form, password) {
  // Check each field has a value
  if (form.email.value == '' || password.value == '') {
     alert('You must provide both email and password');
     return false;
  }
  
  re = /.+@.+$/; 
  if(!re.test(form.email.value)) { 
      alert("Please give a valid email address"); 
      form.email.focus();
      return false; 
  }

  // Check that the password is sufficiently long (min 6 chars)
  // The check is duplicated below, but this is included to give more
  // specific guidance to the user
  if (password.value.length < 6 || password.value.length > 20) {
     alert('Passwords must be at least 6 chars long, and at most 20 chars.');
     form.password.focus();
     return false;
  }
  
  // Create a new element input, this will be our hashed password field. 
  var p = document.createElement("input");

  // Add the new element to our form. 
  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = Sha256.hash(password.value);

  // Make sure the plaintext password doesn't get sent. 
  password.value = "";

  // Finally submit the form. 
  form.submit();
  return true;
}

function signup_form_hash(form, email, fname, lname, password, password2) {
  // Check each field has a value
  if (email.value == '' || fname.value == '' || 
      lname.value == '' || password.value == '' ||
      password2 == '') {
     alert('You must provide all the requested details. Please try again');
     return false;
  }
  
  re = /.+@.+$/; 
  if(!re.test(form.email.value)) { 
      alert("Please give a valid email address"); 
      form.email.focus();
      return false; 
  }

  // Check that the password is sufficiently long (min 6 chars)
  // The check is duplicated below, but this is included to give more
  // specific guidance to the user
  if (password.value.length < 6 || password.value.length > 20) {
     alert('Passwords must be at least 6 chars long, and at most 20 chars.');
     form.password.focus();
     return false;
  }

  // Check password and confirmation are the same
  if (password.value != password2.value) {
     alert('Your password and confirmation do not match. Please try again');
     form.password.focus();
     return false;
  }

  // Create a new element input, this will be our hashed password field. 
  var p = document.createElement("input");

  // Add the new element to our form. 
  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = Sha256.hash(password.value);

  // Make sure the plaintext password doesn't get sent. 
  password.value = "";
  password2.value = "";

  // Finally submit the form. 
  form.submit();
  return true;
}


