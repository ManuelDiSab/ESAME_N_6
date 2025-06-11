import { Directive, EventEmitter, HostListener, Input, Output } from '@angular/core';
import { filter, interval, Observable, Subject, takeUntil, tap } from 'rxjs';

@Directive({
  selector: '[BtnGest]'
})
export class BtnGestioneDirective  {

  @Input() tMax:number = 1000
  @Output() percPress:EventEmitter<number> = new EventEmitter
  stato$:Subject<string> = new Subject()
  cancellato$:Observable<string> 


  constructor(){
    this.cancellato$ = this.stato$.pipe(filter( x => x==='Uscito'),
    tap( x => {
      console.log('%c Fine pressione', 'color:red; font-weight:bold;')
      this.percPress.emit(0)  
    }))
   }

   @HostListener('mouseup', ['$event'])
   @HostListener('mouseleave', ['$event'])
   quandoEsci(){
     console.log('esco dal bottone')
     this.stato$.next('Uscito')
   }
 
 
   @HostListener('mousedown',['$event'])
   quandoPremi(){
     console.log('%c Inizia la pressione', 'color:magenta; font-weight:bold;')
     this.stato$.next('Inizia')
     const n = 100
     interval(n).pipe(
       takeUntil(this.cancellato$),
       tap(x => {
         const v = x * n
         const perc = Math.ceil(100 / this.tMax * v)
         if(v <= this.tMax){
         this.percPress.emit(perc)
         }                 
       })
     ).subscribe()
   }

}
