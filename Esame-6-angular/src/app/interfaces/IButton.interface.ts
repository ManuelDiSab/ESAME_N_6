import { ReactiveFormsModule } from "@angular/forms";

export interface IButton {
    type:'button' | 'submit',
    name:string | null, 
}

class Button implements IButton{
    type: "button" | "submit";
    name: string | null;
    constructor(type:'button' | 'submit', name:string){
        this.name = name;
        this.type = type;
    }                                            
}

interface IVisibilitàPasword extends IButton {
    vedo:'bi-eye-fill'
    nonVedo:'bi-eye-slash-fill',
    input_type:'text' | 'password'
}


