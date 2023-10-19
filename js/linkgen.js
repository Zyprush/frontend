import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js'
import 'sha256.js'
const { createClient } = supabase
supabase = createClient('https://iiyjcebvadflxqplsydx.supabase.co', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlpeWpjZWJ2YWRmbHhxcGxzeWR4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE2NTY0ODc5MDIsImV4cCI6MTk3MjA2MzkwMn0.7XmoOuqI8Jj0mtCoYlDFyoTeHTqyFWdlybLkBF8TdVU')

async function generateLink(pName, webinarID) {
    //generate hash for the link
    const secret = participantName + webinarID
    const hash = sha256(secret)

    // Then store it to our Postgres DB
    // This doesn't include link handling, that's handled somewhere else.
    // PS: Make sure this has a TTL, and this is removed once this is used!
    supabase.from("user_links").insert([{participantName: pName, hashString: hash}]);

}
