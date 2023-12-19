
import endpoint from "../storage";

export async function getIconsData() {
    try {
      const response = await fetch(`${endpoint}/multimedias`, {
        method: 'GET',
        headers: {
        'Authorization' : `Bearer ${localStorage.getItem('accessToken')}`,	
        'Content-Type': 'application/json'
        },
      });
    
      if (response.ok) {
      // icons = await response.json(); 
          return await response.json();
      } else {
        console.error("Erreur lors de la récupération des données des catégories");
      }
    } catch (error) {
      console.error("Une erreur s'est produite:", error);
    }
    
}