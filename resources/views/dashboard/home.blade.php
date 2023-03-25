@extends('layouts.admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-8 col-lg-8 col-xl-8 order-0 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Order Statistics</h5>
              <small class="text-muted">{{ $order->count() }} Total Order</small>
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="orederStatistics"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                <a class="dropdown-item" href="{{ route('admin.order') }}">View More</a>
                <a class="dropdown-item" href="" onClick="window.location.reload();return false;">Refresh</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2 produkTerjual">{{ $produkTerjual }}</h2>   
                <span>Total Produk Terjual</span>
              </div>
              <div id="orderStatisticChart"></div>
            </div>
            {{-- <div>
              {!! $chart->container() !!}
              < src="{{ $chart->cdn() }}"></>
              {!! $chart->() !!}
            </div> --}}
            <ul class="p-0 m-0">
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary"
                      ><img src="../assets_admin/img/icons/unicons/makeup.png" alt="makeup" /></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Make Up</h6>
                      <small class="text-muted">Lipstick, Maskara, Foundation, dll</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold jmlcat1">
                        @if ($categories[1]->orderdetails_sum_jumlah)
                          {{ $categories[1]->orderdetails_sum_jumlah }}
                        @else
                          0
                        @endif
                      </small>
                    </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-success"><img src="../assets_admin/img/icons/unicons/bodycare.png" alt="bodycare" /></i></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Body Care</h6>
                      <small class="text-muted">Lotion, Scrub, Sabun, dll</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold jmlcat2">
                        @if ($categories[2]->orderdetails_sum_jumlah)
                          {{ $categories[2]->orderdetails_sum_jumlah }}
                        @else
                          0
                        @endif
                      </small>
                    </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info"><img src="../assets_admin/img/icons/unicons/skincare.png" alt="skincare" /></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Skin Care</h6>
                      <small class="text-muted">Moisturizer, Serum, Toner, dll</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold jmlcat3">
                        @if ($categories[0]->orderdetails_sum_jumlah)
                          {{ $categories[0]->orderdetails_sum_jumlah }}
                        @else
                          0
                        @endif
                      </small>
                    </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info"><img src="../assets_admin/img/icons/unicons/haircare.png" alt="haircare" /></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Hair Care</h6>
                      <small class="text-muted">Hair Serum, Shampoo, Conditioner, dll</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold jmlcat4">
                        @if ($categories[3]->orderdetails_sum_jumlah)
                          {{ $categories[3]->orderdetails_sum_jumlah }}
                        @else
                          0
                        @endif
                      </small>
                    </div>
                  </div>
                </li>
                <li class="d-flex">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-secondary"
                      ><img src="../assets_admin/img/icons/unicons/lainnya.png" alt="lainnya" /></span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">Lainnya</h6>
                      <small class="text-muted">Masker, Tissue, dll</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold jmlcat5">
                        @if ($categories[4]->orderdetails_sum_jumlah)
                          {{ $categories[4]->orderdetails_sum_jumlah }}
                        @else
                          0
                        @endif
                      </small>
                    </div>
                  </div>
                </li>
            </ul>
          </div>
        </div>
      </div>
      <!--/ Order Statistics -->

      <!-- Pengeluaran dan Pemasukan Bulan Ini -->
      <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
          <div class="col-12 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="../assets_admin/img/icons/unicons/expense.png" alt="expense" class="rounded" />
                  </div>
                  <span class="fw-semibold d-block mb-1 pt-2">Pengeluaran Bulan Ini</span>
                  <div class="dropdown">
                    <button
                      class="btn p-0 pt-2"
                      type="button"
                      id="cardOpt4"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                      <a class="dropdown-item" href="{{ route('admin.expense') }}">View More</a>
                    </div>
                  </div>
                </div>
                <h3 class="card-title text-nowrap mb-2 p-2">Rp {{ number_format($expense,0, ',' , '.') }}</h3>
                <small class="text-danger fw-semibold">
                  @if ($expensepersen > 0)
                    <i class="bx bx-up-arrow-alt"></i>                      
                  @elseif ($expensepersen < 0)
                    <i class="bx bx-down-arrow-alt"></i>
                  @else
                    <i class="bx bx-pause bx-rotate-90"></i>                      
                  @endif
                  {{ $expensepersen }}% dari bulan lalu
                </small>
              </div>
            </div>
          </div>
          <div class="col-12 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="../assets_admin/img/icons/unicons/income.png"
                      alt="income"
                      class="rounded"
                    />
                  </div>
                  <span class="fw-semibold d-block mb-1 pt-2">Pemasukan Bulan Ini</span>
                  <div class="dropdown">
                    <button
                      class="btn p-0 pt-2"
                      type="button"
                      id="cardOpt3"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="{{ route('admin.income') }}">View More</a>
                    </div>
                  </div>
                </div>
                <h3 class="card-title mb-2 p-2">Rp {{ number_format($income,0, ',' , '.') }}</h3>
                <small class="text-success fw-semibold">
                  @if ($incomepersen > 0)
                    <i class="bx bx-up-arrow-alt"></i>                      
                  @elseif ($incomepersen < 0)
                    <i class="bx bx-down-arrow-alt"></i>
                  @else
                    <i class="bx bx-pause bx-rotate-90"></i>                      
                  @endif
                  {{ $incomepersen }}% dari bulan lalu
                </small>
              </div>
            </div>
          </div>
          <div class="col-12 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="../assets_admin/img/icons/unicons/profit.png"
                      alt="profit"
                      class="rounded"
                    />
                  </div>
                  <span class="fw-semibold d-block mb-1 pt-2 ps-3">Profit Bulan Ini</span>
                </div>
                <h3 class="card-title mb-2 p-2">Rp {{ number_format($income-$expense,0, ',' , '.') }}</h3>
                <small class="text-info fw-semibold">
                  @if ($profitpersen > 0)
                    <i class="bx bx-up-arrow-alt"></i>                      
                  @elseif ($profitpersen < 0)
                    <i class="bx bx-down-arrow-alt"></i>
                  @else
                    <i class="bx bx-pause bx-rotate-90"></i>                      
                  @endif
                  {{ $profitpersen }}% dari bulan lalu
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Pengeluaran dan Pemasukan Bulan Ini -->
    </div>
  </div>
@endsection

@section('script')
  {{-- Donut Order Statistics Chart --}}
  <script>
    let headingColor, axisColor, makeup, skincare, bodycare, haircare, lainnya, total;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    makeup = parseInt($(".jmlcat1").text());
    bodycare = parseInt($(".jmlcat2").text());
    skincare = parseInt($(".jmlcat3").text());
    haircare = parseInt($(".jmlcat4").text());
    lainnya = parseInt($(".jmlcat5").text());
    total = $(".produkTerjual").text();

    // Order Statistics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#orderStatisticChart'),
      orderChartConfig = {
        chart: {
          height: 165,
          width: 130,
          type: 'donut'
        },
        labels: ["Make Up", "Body Care", "Skin Care", "Hair Care", "Lainnya"],
        series: [makeup, bodycare, skincare, haircare, lainnya],
        colors: [config.colors.danger, config.colors.success, config.colors.warning, config.colors.info, config.colors.primary],
        dataLabels: {
          enabled: false,
          formatter: function (val, opt) {
            return parseInt(val) + ' pcs';
          }
        },
        legend: {
          show: false
        },
        grid: {
          padding: {
            top: 0,
            bottom: 0,
            right: 15
          }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '75%',
              labels: {
                show: true,
                value: {
                  fontSize: '1.5rem',
                  fontFamily: 'Public Sans',
                  color: headingColor,
                  offsetY: -15,
                  formatter: function (val) {
                    return parseInt(val) + ' pcs';
                  }
                },
                name: {
                  offsetY: 20,
                  fontFamily: 'Public Sans'
                },
                total: {
                  show: true,
                  fontSize: '0.8125rem',
                  color: axisColor,
                  label: 'Weekly',
                  formatter: function (w) {
                    return total;
                  }
                }
              }
            }
          }
        }
      };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
      const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
      statisticsChart.render();
    }
    </script>
@endsection
