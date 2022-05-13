import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import Frame from '@/layouts/frame';
import Challenge from '@/components/challenge';

export default function ChallengeList({ team, group, challenges }) {
  return (
    <>
      <Head title="Challenges" />
      <Frame team={ team } group={ group }>
        { challenges.map(p => (<Challenge key={ p.id } data={ p } />)) }
      </Frame>
    </>
  );
}
