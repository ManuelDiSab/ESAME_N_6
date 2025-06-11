import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormSerieComponent } from './form-serie.component';

describe('FormSerieComponent', () => {
  let component: FormSerieComponent;
  let fixture: ComponentFixture<FormSerieComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [FormSerieComponent]
    });
    fixture = TestBed.createComponent(FormSerieComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
