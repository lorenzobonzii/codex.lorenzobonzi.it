import { Component } from '@angular/core';
import { Genre } from '../../models/genre';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { SliderComponent } from '../../components/slider/slider.component';
import { BannerComponent } from '../../components/banner/banner.component';
import { BreadcrumbComponent } from '../../components/breadcrumb/breadcrumb.component';
import { ApiService } from '../../services/api/api.service';

@Component({
  selector: 'app-series-genre',
  standalone: true,
  imports: [CommonModule, BreadcrumbComponent, BannerComponent, SliderComponent],
  templateUrl: './series-genre.component.html',
  styleUrl: './series-genre.component.scss'
})
export class SeriesGenreComponent {
  constructor(private apiService: ApiService, private route: ActivatedRoute) { }
  genre!: Genre[];
  items_for_row = 5;
  id_genre!: number;
  isLoading = true;

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_genre = params['id'];
      this.apiService.getGenre(this.id_genre).subscribe((genre) => {
        this.genre = [genre];
        var genere = this.genre[0];
        this.apiService.getSeriesGenre(genere.id).subscribe((series) => {
          genere.movies = series;
          var original_length = genere.movies.length;
          while (genere.movies.length > 0 && genere.movies.length < this.items_for_row) {
            for (var i = 0; i < original_length; i++) {
              genere.movies.push(genere.movies[i]);
            }
          }
          genere.movies.splice(10, genere.movies.length - 10);
          this.isLoading = false;
        });
      });
    });
  }
}