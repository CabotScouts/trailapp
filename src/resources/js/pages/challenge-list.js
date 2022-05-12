import React from 'react';
import Frame from '@/layouts/frame';
import Challenge from '@/components/challenge';
import { Head, useForm } from '@inertiajs/inertia-react';

export default function ChallengeList(props) {

  return (
    <>
      <Head title="Challenge List" />
      <Frame team={ props.team } group={ props.group }>
        { props.challenges.map(p => (<Challenge key={ p.id } data={ p } />)) }
      </Frame>
    </>
  );

}
