import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

export default function Global({ children }) {
  const { auth } = usePage().props;
  
  useEffect(() => {
    window.Echo.private(`team.${auth.user.id}`).listenToAll((e, d) => { console.log(e, d) });
  });
  
  return (
    <>
      { children }
    </>
  );
}
