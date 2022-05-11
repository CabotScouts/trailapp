import React from 'react';
import Frame from '@/layouts/frame';
import Challenge from '@/components/challenge';
import { Head, useForm } from '@inertiajs/inertia-react';

export default function Trail(props) {

  return (
    <>
      <Head title="Heritage Trail" />
      <Frame team={ props.team }>
        { props.challenges.map(p => (<Challenge key={ p.id } data={ p } />)) }
      </Frame>
    </>
  );

}
