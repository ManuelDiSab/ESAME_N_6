export type ErrorType = 'required' | 'email' | 'minLength' | 'maxLength' | 'invalidDate' | 'invalidYear'


export const ERROR_MESSAGES: { [chiave:string]:(...args:any)=> string} = {
    required:(formControlName:string) =>  `${formControlName} è richiesto/a`,
    email:() => 'Questa email non è valida',
    minLength:(formControlName,requirement) => `${formControlName} dovrebbe essere almeno lunga ${requirement} caratteri`,
    maxLength:(formControlName,requirement)=> `${formControlName} può avere al massimo ${requirement} caratteri`,
    invalidDate:() => 'La data deve essere in formato yyyy-mm-dd',
    invalidYear:() => 'La data di nascita dovrebbe essere dopo il 1900',
};