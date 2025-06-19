<?php if($gcat) : ?>
<script>
    am5.ready(function() {

    // Create root element
    var root = am5.Root.new("display_category");

    // Set themes
    root.setThemes([
      am5themes_Animated.new(root)
    ]);

    // Create chart
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "none",
      wheelY: "none",
      paddingLeft: 0
    }));

    // Hide zoom-out button
    chart.zoomOutButton.set("forceHidden", true);

    // Create Y Axis (Category)
    var yRenderer = am5xy.AxisRendererY.new(root, {
      minGridDistance: 30,
      minorGridEnabled: true
    });

    yRenderer.grid.template.set("location", 1);

    var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
      maxDeviation: 0,
      categoryField: "category",
      renderer: yRenderer,
      tooltip: am5.Tooltip.new(root, { themeTags: ["axis"] })
    }));

    // Create X Axis (Value)
    var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
      maxDeviation: 0,
      min: 0,
      numberFormatter: am5.NumberFormatter.new(root, {
        numberFormat: "#,###a"
      }),
      extraMax: 0.1,
      renderer: am5xy.AxisRendererX.new(root, {
        strokeOpacity: 0.1,
        minGridDistance: 80
      })
    }));

    xAxis.get("numberFormatter").set("numberFormat", "#");

    // Create series
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueXField: "value",
      categoryYField: "category",
      tooltip: am5.Tooltip.new(root, {
        pointerOrientation: "left",
        labelText: "{valueX} Berita"
      })
    }));

    // Rounded corners
    series.columns.template.setAll({
      cornerRadiusTR: 5,
      cornerRadiusBR: 5,
      strokeOpacity: 0
    });

    // Use AM5 default color palette (random color per bar)
    series.columns.template.adapters.add("fill", function (fill, target) {
      return chart.get("colors").getIndex(series.dataItems.indexOf(target.dataItem));
    });

    series.columns.template.adapters.add("stroke", function (stroke, target) {
      return chart.get("colors").getIndex(series.dataItems.indexOf(target.dataItem));
    });

    // Set data from PHP
    var data = <?= json_encode($gcat); ?>;

    yAxis.get("renderer").labels.template.setAll({
    oversizedBehavior: "wrap",
    maxWidth: 100,
    textAlign: "start"
    });

    yAxis.data.setAll(data);
    series.data.setAll(data);

    sortCategoryAxis();

    // Get series item by category
    function getSeriesItem(category) {
      for (var i = 0; i < series.dataItems.length; i++) {
        var dataItem = series.dataItems[i];
        if (dataItem.get("categoryY") == category) {
          return dataItem;
        }
      }
    }

    // Enable cursor
    chart.set("cursor", am5xy.XYCursor.new(root, {
      behavior: "none",
      xAxis: xAxis,
      yAxis: yAxis
    }));

    // Sort Y axis based on value descending
    function sortCategoryAxis() {
      series.dataItems.sort(function (x, y) {
        return x.get("valueX") - y.get("valueX");
      });

      am5.array.each(yAxis.dataItems, function (dataItem) {
        var seriesDataItem = getSeriesItem(dataItem.get("category"));
        if (seriesDataItem) {
          var index = series.dataItems.indexOf(seriesDataItem);
          var deltaPosition = (index - dataItem.get("index", 0)) / series.dataItems.length;
          dataItem.set("index", index);
          dataItem.set("deltaPosition", -deltaPosition);
          dataItem.animate({
            key: "deltaPosition",
            to: 0,
            duration: 1000,
            easing: am5.ease.out(am5.ease.cubic)
          });
        }
      });

      yAxis.dataItems.sort(function (x, y) {
        return x.get("index") - y.get("index");
      });
    }

    // Animasi saat load
    series.appear(1000);
    chart.appear(1000, 100);

    }); // end am5.ready()
</script>
<?php endif;?>