import { Injectable } from '@angular/core';
import { BehaviorSubject, count } from 'rxjs';
import { IComune } from '../interfaces/IComune.interface';
import { INazione } from '../interfaces/INazione.interface';

@Injectable({
    providedIn: 'root'
})
export class RegisterService {

    static n_form$: BehaviorSubject<number | null> = new BehaviorSubject<number | null>(null)
    private comune$: BehaviorSubject<IComune | null> = new BehaviorSubject<IComune | null>(null)
    private nazione$: BehaviorSubject<INazione | null> = new BehaviorSubject<INazione | null>(null)
    constructor() {

    }

    getComune():BehaviorSubject<IComune | null> {
        return this.comune$
    }
    setComune(comune: IComune | null): void {
        if( comune !== null && (this.comune$.value === null || this.comune$.value.idComune !== comune.idComune))
            this.comune$.next(comune)
    }

    getNazione():BehaviorSubject<INazione | null> {
        return this.nazione$
    }
    setNazione(nazione: INazione | null): void {
        if( nazione !== null && (this.nazione$.value === null || this.nazione$.value.idNazione !== nazione.idNazione))
            this.nazione$.next(nazione)
    }






    avanti(n: number): void {
        n += 1
    }
    indietro(n: number): void {
        n -= 1
    }
}
