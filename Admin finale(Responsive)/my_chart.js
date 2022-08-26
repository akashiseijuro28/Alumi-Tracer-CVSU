const Alumni = document.getElementById('Alumni').getContext('2d'); 
const myChart = new Chart(Alumni, { 
		type: 'bar', data: { labels: [2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014 ], 
		datasets: [{ 
				label: 'Alumni Chart', data: [2000, 1000, 3500, 3000, 1200, 4030, 5600, 3400], 
				backgroundColor: [ 
						'rgba(42,155,99, 0.9)', 
						'rgba(230, 172, 62)',
				], 		
		}] 
	}, 
	options: { 
			responsive: true,
	}
});
						



const chart2 = document.getElementById("chart2").getContext("2d");
const myChart3 = new Chart(chart2, {
  type: "bar",
  data: {
    labels: ["Business woman/man", "Web Developer", "IT", "Call Center", "Sales", "Seaman", "Accounting" ],
    datasets: [
      {
        label: 'Employment Status', data: [2000, 1000, 3500, 3000, 1200, 5600, 3400], 
      
        backgroundColor: [
          'rgba(42,155,99, 0.9)', 
          'rgba(230, 172, 62)',
          
        ],
      },
    ],
  },
  options: {
    responsive: true,
  },
});
const chart1 = document.getElementById("chart1").getContext("2d");
const myChart2 = new Chart(chart1, {
  type: "polarArea",
  data: {
    labels: ["Registered", "Not Registered", "Others"],
    datasets: [
      {
        label: "Students Registered in Alumni Tracking System",
        data: [500, 200, 25],
        backgroundColor: [
          "rgba(54, 162, 235, 1)",
          "rgba(255, 99, 132, 1)",
          "rgba(255, 206, 86, 1)",
        ],
      },
    ],
  },
  options: {
    responsive: true,
  },
});