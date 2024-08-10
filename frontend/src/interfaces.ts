export interface User {
  username: String;
  password: String;
}

export interface RegistUser {
  username: String;
  password: String;
  confirmPassword: String;
}

export interface ResetPassUser {
  oldPassword: String;
  password: String;
  confirmPassword: String;
}

export interface JenisType {
  jenisGerakan: String;
  perRakaat: Number;
}
