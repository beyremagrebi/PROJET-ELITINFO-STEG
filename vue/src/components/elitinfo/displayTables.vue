<template>
    <div>
        <div class="tables">
         <div class="compteA">
            <h4>Non Rapproché {{form.codeb.substr(0,form.codeb.indexOf('-'))}}</h4>
            <div v-if="loadA">
                <b-spinner  label="Spinning"></b-spinner>
            </div>
            <div v-else>
                <h5 v-if="compteA.length>0">{{compteA.length}}</h5>
                <h5 v-else class="badge bg-dark">aucune donnée</h5>
            </div>
            
            <div v-if="compteA.length>0" class="details">
                <b-button v-b-toggle.collapse-2 class="show" size="sm" ><i class="fa-solid fa-eye"></i></b-button>
            </div>
                        <div class="mb-2" style="padding:20px;">
               
            </div>
             <b-collapse  v-if="compteA.length>0" id="collapse-2" class="mt-2">
                <b-card bg-variant="default">
                    <div >
                            <v-table class="compteA-table" 
                            :currentPage.sync="currentPage"
                             :pageSize="5"
                             @totalPagesChanged="totalPages = $event"
                            :data="compteA">
                            <thead slot="head">
                                <th>Code Autorisation</th>
                                <th>Montant</th>
                                <th>Date Opération</th>
                                <th>Analyse</th>
                         </thead>

             <tbody slot="body" slot-scope="{displayData}">
                <tr v-for="row in displayData" :key="row.id">
                <td>{{ row.code }}</td>
                <td>{{ row.Montant }}</td>
                <td>{{ row.DateOperation.substr(0,row.DateOperation.indexOf(' '))}}</td>
                <td>
                    1
                </td>
                </tr>
            </tbody>
                </v-table>
                        <div class="pagination">
                  <smart-pagination
                    :currentPage.sync="currentPage"
                    :totalPages="totalPages"
                    :maxPageLinks="3"
                />

                        </div>

                    </div>
                

                </b-card>
              
            </b-collapse>
        </div>
        <div class="compteB">
          <h4>Non Rapproché {{form.codeb.substr(form.codeb.indexOf('-')+1)}}</h4>
          <div v-if="loadB">
            <b-spinner  label="Spinning"></b-spinner>
          </div>
          <div v-else>
                <h5 v-if="compteB.length>0">{{compteB.length}}</h5>
                <h5 v-else class="badge bg-dark">aucune donée</h5>
          </div>
            
            <div v-if="compteB.length>0" class="details">
                <b-button v-b-toggle.collapse-1 class="show" size="sm"><i class="fa-solid fa-eye"></i></b-button>

            </div>
                     <div class="mb-2" style="padding:20px;">
               
            </div>
             <b-collapse v-if="compteB.length>0" id="collapse-1" class="mt-2">
                <b-card>

                    <div >
                            <v-table class="compteA-table compteB-table" 
                            :currentPage.sync="currentPageB"
                             :pageSize="5"
                             @totalPagesChanged="totalPagesB = $event"
                            :data="compteB">
                            <thead slot="head">
                                <th>Code Autorisation</th>
                                <th>Montant</th>
                                <th>Date Opération</th>
                                <th>Analyse</th>
                         </thead>

             <tbody slot="body" slot-scope="{displayData}">
                       
                        
                    
                <tr v-for="row in displayData" :key="row.id">
                <td>{{ row.code }}</td>
                <td>{{ row.montant }}</td>
                <td>{{ row.dateOperation.substr(0,row.dateOperation.indexOf(' '))}}</td>
                <td>
                    1
                </td>
                </tr>
            </tbody>
                </v-table>
                        <div class="pagination">
                  <smart-pagination
                    :currentPage.sync="currentPageB"
                    :totalPages="totalPagesB"
                    :maxPageLinks="3"
                />

                        </div>

                    </div>
                

                </b-card>
              
            </b-collapse>
        </div>

        </div>
        </div>
        
  
</template>

<script>
export default{
   // props:['compteA','compteB','form','listcompte','loadA','loadB'],
       props:{
        listcompte:Array,
        form:Object,
        compteA:Array,
        compteB:Array,
        loadA:Boolean,
        loadB:Boolean
    },
    data(){
        return{
            currentPage: 1,
            totalPages: 0,
             currentPageB: 1,
            totalPagesB: 0
        }
    },
    methods:{

    }
}
</script>

<style>
.tables{
    display: flex;
    margin:5%;
    

    align-items:flex-start
 
}
    .compteA{
        background-color: rgb(102, 255, 0);
        padding:20px;
        margin-right:5%;
        width:700px;
        text-align: center;
        color: white;
       /* box-shadow: rgb(61, 207, 32) 6px 3px 8px;*/
       
    }
    .compteB{
        background-color: rgb(84, 84, 223);
        padding:20px;
        margin-right:5%;
        width:700px;
        text-align: center;
        color: white;
        /* box-shadow: rgb(255, 102, 0) 6px 3px 8px; */
    }

    .tables .details .show{
float: right;
        background-color: black;
        cursor:pointer
    }


    .compteA-table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  color: black;
}

.compteA-table td, .compteA-table th {
  border: 1px solid #ddd;
  padding: 8px;
  
}

.compteA-table tr:nth-child(even){background-color: #f2f2f2;}

.compteA-table tr:hover {background-color: #ddd;}

.compteA-table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #008cff;
  color: white;
}

.compteB-table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #008cff;
  color: white;
}
.pagination{
   margin-left:16%;
}

.collapse{
    justify-content:center;
    
}
</style>