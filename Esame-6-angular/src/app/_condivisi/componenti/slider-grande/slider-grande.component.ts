import { Component, Input } from '@angular/core';
import { IFilm } from 'src/app/interfaces/IFilm.interface';
import { ISerie } from 'src/app/interfaces/ISerie.interface';
import { NgbCarouselConfig } from '@ng-bootstrap/ng-bootstrap';
import { UtilityService } from 'src/app/_servizi/utility.service';
import { iif } from 'rxjs';

@Component({
  selector: 'slider-grande',
  templateUrl: './slider-grande.component.html',
  styleUrls: ['./slider-grande.component.scss']
})
export class SliderGrandeComponent {

  @Input('elementi') film!: (IFilm | ISerie)[]
  @Input('titolo') titolo!: string
  @Input('icona') icona: string | null = null
  constructor(private config: NgbCarouselConfig, private utility:UtilityService) {
    this.config.showNavigationArrows = false
  }
  ngOnInit(): void {
  }

  /**
   * Funzione per aggiungere il film o la serie ai preferiti
   * @param item IFilm o ISerie (interface per i film / Interface per le serie tv )
   * @returns void
   */
  preferiti(item:(IFilm | ISerie), i:HTMLElement) {
    this.utility.AddPreferiti(item)
    i.className = 'bi-bookmark-fill' 
  }

  /**
   * Funzione per togliere un film o una serie dai preferiti
   * @param item IFilm | ISerie
   * @returns void
   */
  TogliPreferito(item:(IFilm|ISerie), i:HTMLElement):void{
    this.utility.TogliDaiPreferiti(item)
    i.className = 'bi-bookmark' 
  }


}
