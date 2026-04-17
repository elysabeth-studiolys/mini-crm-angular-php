import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Deal, DealService } from '../../services/deal.service';
import { LucideAngularModule } from 'lucide-angular';

import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-deals',
  standalone: true,
  imports: [CommonModule, LucideAngularModule, FormsModule],
  templateUrl: './deals.html',
  styleUrl: './deals.scss',
})


export class DealsComponent implements OnInit {

  deals: Deal[] = [];

  constructor(
    private dealService: DealService,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.dealService.getAll().subscribe(data => {
      console.log(data);
      this.deals = data;
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
  }

  delete(id: number): void {
    this.dealService.delete(id).subscribe(() => {
      this.deals = this.deals.filter(d => d.id_contact !== id);
    })
  }
}